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

namespace axguowen\ctyun\common\utils;

class Str
{
    /**
     * 生成UUID
     * @access public
     * @param bool $upper
     * @return string
     */
    public static function uuid($upper = false): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff )
        );
    }

    /**
     * hmacsha256加密
     * @access public
     * @param string $str
     * @param string $secretKey
     * @return string
     */
    public static function hmacsha256($str = '', $secretKey = ''): string
    {
        return hash_hmac('sha256', $str, $secretKey, true);
    }
}