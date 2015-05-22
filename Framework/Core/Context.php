<?php
/**
 * 上下文、服务器环境相关
 * @since 2015-01-02 17:36:05
 */

class Core_Context
{
    private static $_inited = false;
    private static $_contextData;

    /**
     * 上下文初始化
     * @return NULL
     */
    public static function init()
    {
        if (self::$_inited) return;
        self::$_contextData = array();
        self::$_inited = true;
    }

    /**
     * 获取GET参数
     * @param  string $name       GET参数名
     * @param  mixed $ifNotExist  如果不存在，则返回该值
     * @return string
     */
    public static function get($name, $ifNotExist = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : $ifNotExist;
    }

    /**
     * 获取POST参数
     * @param  string $name       POST参数名
     * @param  mixed $ifNotExist  如果不存在，则返回该值
     * @return string
     */
    public static function post($name, $ifNotExist = null)
    {
        return isset($_POST[$name]) ? $_POST[$name] : $ifNotExist;
    }

    /**
     * 获取Cookie
     * @param  string $name       Cookie字段名
     * @param  mixed $ifNotExist  如果不存在，则返回该值
     * @return string
     */
    public static function cookie($name, $ifNotExist = null)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $ifNotExist;
    }

    /**
     * 获取REQUEST参数
     * @param  string $name       REQUEST参数名
     * @param  mixed $ifNotExist  如果不存在，则返回该值
     * @return string
     */
    public static function request($name, $ifNotExist = null)
    {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $ifNotExist;
    }

    /**
     * 获取服务器环境变量
     * @param  string $name       环境变量名
     * @param  mixed $ifNotExist  如果不存在，则返回该值
     * @return string
     */
    public static function getServer($name, $ifNotExist = null)
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : $ifNotExist;
    }

    /* 设置上下文变量
     * @param string $name 设置的变量名
     * @param mixed $value 设置的变量值
     * @return bool true:初次设置，false:更新
     */
    public static function setContext($name, $value = null)
    {
        $ret = !isset(self::$_contextData[$name]);
        self::$_contextData[$name] = $value;
        return $ret;
    }

    /**
     * 获取上下文变量
     * @param  string $name       变量名
     * @param  mixed $ifNotExist  如果不存在，则返回该值
     * @return mixed
     */
    public static function getContext($name, $ifNotExist = null)
    {
        return isset(self::$_contextData[$name])
                 ? self::$_contextData[$name]
                 : $ifNotExist;
    }

    /**
     * 获取请求URI
     * @return string URI
     */
    public static function getUri()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $uri = $_SERVER['PATH_INFO'];
        } else {
            if (isset($_SERVER['REQUEST_URI'])) {
                $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                $uri = rawurldecode($uri);
            } elseif (isset($_SERVER['PHP_SELF'])) {
                $uri = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['REDIRECT_URL'])) {
                $uri = $_SERVER['REDIRECT_URL'];
            } else {
                $uri = '/';
            }
            
            $baseUrl = '/index.php';

            if (strpos($uri, $baseUrl) === 0) {
                $uri = substr($uri, strlen($baseUrl));
            }
        }
        
        return $uri;
    }
}
