<?php
/**
 * @author qibing 
 * 
 * 服务器相关操作
 */

class Tool_Server
{
    /**
     * 获取客户端IP地址
     * @return string/bool 成功返回ip地址，失败返回false
     */
    public static function getRemoteAddr()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    $ip = filter_var($ip, FILTER_VALIDATE_IP);
                    if ($ip !== false) {
                        return $ip;
                    }
                }
            }
        }
        return false;
    }
}