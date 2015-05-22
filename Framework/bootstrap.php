<?php
/**
 * 框架初始化
 * @since 2015-01-02 15:40:40
 */

// 设置错误级别
if (isset($_SERVER['APP_ENV']) && $_SERVER['APP_ENV'] == 'production') {
    ini_set('error_reporting', E_ALL & ~E_NOTICE);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
} else {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', '1');
    ini_set('log_errors', '1');
}

// 设置locale和timezone
setlocale (LC_ALL, 'zh_CN.utf-8');
date_default_timezone_set('Asia/Shanghai');

// 设置类自动加载
require_once FRAMEWORK_DIR . DS . 'Core' . DS . 'Common.php';
spl_autoload_register(array('Core_Common', 'autoLoad'));

// Application自定义初始化
if (file_exists(APPLICATION_DIR . DS . 'bootstrap.php')) {
    require_once APPLICATION_DIR . DS . 'bootstrap.php';
}

// 上下文初始化
Core_Context::init();

// 路由
Core_Router::route();
