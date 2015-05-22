<?php
/**
 * 框架核心类 公共部分
 * @since 2015-01-02 17:28:01
 */

class Core_Common
{
    /**
     * 自动加载
     * @param  string $className 类名
     * @return bool            是否加载成功
     */
    public static function autoLoad($className)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $className)) {
            return false;
        }

        $file = str_replace('_', DS, $className) . '.php';
        
        if (strpos($className, 'Core_') === 0 || $className === 'Controller_Abstract') {
            $file = FRAMEWORK_DIR . DS . $file;
        } else if (file_exists(APPLICATION_DIR . DS . $file)) {
            $file = APPLICATION_DIR . DS . $file;
        } else if (file_exists(FRAMEWORK_DIR . DS . $file)) {
            $file = FRAMEWORK_DIR . DS . $file;
        }

        if (file_exists($file)) {
            require_once $file;
        }

        return class_exists($className, false);
    }
}
