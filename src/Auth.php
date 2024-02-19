<?php
// +----------------------------------------------------------------------
// | Ctyun common [Ctyun php sdk common package]
// +----------------------------------------------------------------------
// | Ctyun sdk 公共依赖
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axguowen <axguowen@qq.com>
// +----------------------------------------------------------------------

namespace axguowen\ctyun\common;

class Auth
{
    /**
     * 公钥
     * @var string
     */
	protected $accessKey = '';

    /**
     * 私钥
     * @var string
     */
	protected $securityKey = '';

    /**
     * 构造方法
     * @access public
     * @param string $accessKey 公钥
     * @param string $securityKey 私钥
     * @return void
     */
    public function __construct($accessKey, $securityKey)
    {
        // 设置公钥和私钥
        $this->accessKey = $accessKey;
        $this->securityKey = $securityKey;
    }

    /**
     * 获取授权请求头参数
     * @access public
     * @param string $url 要请求的接口地址
     * @param array $body 请求体
     * @return string
     */
    public function authorization($url, $body = [])
    {
        // 生成请求流水号
        $requestId = utils\Str::uuid();
        // 请求时间
        $requestTime = time();
        // 生成签名时间
        $signatureTime = date('Ymd', $requestTime) . 'T' . date('His', $requestTime) . 'Z';
        // 签名日期
        $signatureDate = substr($signatureTime, 0, 8);
        // 请求query待签名字符串
        $query = '';
        // 获取url解析结果
        $parseUrlResult = parse_url($url);
        // 如果存在query
        if(isset($parseUrlResult['query']) && !empty($parseUrlResult['query'])){
            // 获取query参数
            $queryData = explode('&', $parseUrlResult['query']);
            // 排序
            sort($queryData);
            // 拼接query待签名字符串
            $query = implode('&', $queryData);
        }
        // 如果请求体是数组
        if(is_array($body)){
            // 转换为JSON字符串
            $body = json_encode($body);
        }
        // 构造请求体待签名字符串
        $body = bin2hex(hash('sha256', $body, true));
        // 拼接待签名字符串
        $signatureStr = implode('', [
            'ctyun-eop-request-id:',
            $requestId,
            "\n",
            'eop-date:',
            $signatureTime,
            "\n",
            "\n",
            $query,
            "\n",
            $body,
        ]);
        // 计算ktime
        $ktime = utils\Str::hmacsha256($signatureTime, $this->securityKey);
        // 计算kAk
        $kAk = utils\Str::hmacsha256($this->accessKey, $ktime);
        // 计算kdate
        $kdate = utils\Str::hmacsha256($signatureDate, $kAk);
        // 计算出签名
        $signature = base64_encode(utils\Str::hmacsha256(utf8_encode($signatureStr), $kdate));
        // 构造请求头
        $headers = [
            'ctyun-eop-request-id' => $requestId,
            'eop-authorization' => $this->accessKey . ' Headers=ctyun-eop-request-id;eop-date Signature=' . $signature,
            'eop-date' => $signatureTime,
        ];
        // 返回
        return $headers;
    }
}
