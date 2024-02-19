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

use axguowen\HttpClient;

abstract class BaseClient
{
    /**
     * 授权对象实例
     * @var Auth
     */
    protected $auth;

    /**
     * 请求接口根地址
     * @var string
     */
    protected $baseUrl = 'https://api.ctyun.cn';

    /**
     * 架构函数
     * @access public
     * @param Auth $auth 授权对象实例
     */
    public function __construct(Auth $auth)
    {
        // 授权对象实例赋值
        $this->auth = $auth;
    }

    /**
     * 发送POST请求
     * @access protected
     * @param string $path 请求接口
     * @param array $body 请求参数
     * @return array
     */
    protected function post($path, $body = [])
    {
        // 通过请求接口获取授权请求头
        $headers = $this->auth->authorization($path, $body);
        // 追加请求头
        $headers['Content-Type'] = 'application/json;charset=utf-8';
        // 如果请求体是数组
        if(is_array($body)){
            $body = json_encode($body);
        }
        // 发送请求
        $ret = HttpClient::post($this->baseUrl . $path, $body, $headers);
        if (!$ret->ok()) {
            throw new \Exception($ret->error, $ret->statusCode);
        }
        // 如果响应体为空
        if(!is_null($ret->body)){
            return $ret->json();
        }
        return [];
    }

    /**
     * 发送GET请求
     * @access protected
     * @param string $path 请求接口
     * @param array $query 请求参数
     * @return array
     */
    protected function get($path, $query = [])
    {
        // 如果请求参数不为空
        if(!empty($query)){
            // 拼接请求参数
            $path .= (false === strpos($path, '?') ? '?' : '&') . http_build_query($query);
        }
        // 通过请求接口获取授权请求头
        $headers = $this->auth->authorization($path);
        // 发送请求
        $ret = HttpClient::get($this->baseUrl . $path, $headers);
        if (!$ret->ok()) {
            throw new \Exception($ret->error, $ret->statusCode);
        }
        // 如果响应体为空
        if(!is_null($ret->body)){
            return $ret->json();
        }
        return [];
    }

    /**
     * 发送PUT请求
     * @access protected
     * @param string $path 请求接口
     * @param array $body 请求参数
     * @return array
     */
    protected function put($path, $body = [])
    {
        // 通过请求接口获取授权请求头
        $headers = $this->auth->authorization($path, $body);
        // 追加请求头
        $headers['Content-Type'] = 'application/json;charset=utf-8';
        // 如果请求体是数组
        if(is_array($body)){
            $body = json_encode($body);
        }
        // 发送请求
        $ret = HttpClient::put($this->baseUrl . $path, $body, $headers);
        if (!$ret->ok()) {
            throw new \Exception($ret->error, $ret->statusCode);
        }
        // 如果响应体为空
        if(!is_null($ret->body)){
            return $ret->json();
        }
        return [];
    }

    /**
     * 发送PATCH请求
     * @access protected
     * @param string $path 请求接口
     * @param array $body 请求参数
     * @return array
     */
    protected function patch($path, $body = [])
    {
        // 通过请求接口获取授权请求头
        $headers = $this->auth->authorization($path, $body);
        // 追加请求头
        $headers['Content-Type'] = 'application/json;charset=utf-8';
        // 如果请求体是数组
        if(is_array($body)){
            $body = json_encode($body);
        }
        // 发送请求
        $ret = HttpClient::patch($this->baseUrl . $path, $body, $headers);
        if (!$ret->ok()) {
            throw new \Exception($ret->error, $ret->statusCode);
        }
        // 如果响应体为空
        if(!is_null($ret->body)){
            return $ret->json();
        }
        return [];
    }

    /**
     * 发送DELETE请求
     * @access protected
     * @param string $path 请求接口
     * @param array $query 请求参数
     * @return array
     */
    protected function delete($path, $query = [])
    {
        // 如果请求参数不为空
        if(!empty($query)){
            // 拼接请求参数
            $path .= (false === strpos($path, '?') ? '?' : '&') . http_build_query($query);
        }
        // 通过请求接口获取授权请求头
        $headers = $this->auth->authorization($path);
        // 发送请求
        $ret = HttpClient::delete($this->baseUrl . $path, $headers);
        if (!$ret->ok()) {
            throw new \Exception($ret->error, $ret->statusCode);
        }
        // 如果响应体为空
        if(!is_null($ret->body)){
            return $ret->json();
        }
        return [];
    }
}
