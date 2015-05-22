<?php
/**
 * Drizzle - 开发Web App的PHP框架
 * @since 2015-01-02 15:13:34
 */

header('Content-type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Thu, 01 Jan 2015 00:00:00 GMT');
header('Pragma: no-cache');

define('DS', DIRECTORY_SEPARATOR);
$appDir = rtrim(dirname(__FILE__), DS);
define('APPLICATION_DIR', $appDir);
define('TEMPLATE_DIR', APPLICATION_DIR . DS . 'Template');
define('STATIC_DIR', APPLICATION_DIR . DS . 'Static');
define('FRAMEWORK_DIR', APPLICATION_DIR . DS . '..' . DS . '..' . DS . 'Framework');
define('FRM_T3PARTY_DIR', FRAMEWORK_DIR . DS . 'T3Party');
define('APP_T3PARTY_DIR', APPLICATION_DIR . DS . 'T3Party');
unset($appDir);

require_once FRAMEWORK_DIR . DS . 'bootstrap.php';
