<?php
/**
 * 系统路由相关
 * @since 2015-01-02 17:37:24
 */

class Core_Router
{
    private static $_controller;
    private static $_defaultController = 'Index';
    private static $_controllerClassPrefix = 'Controller_';
    private static $_controllerClass;
    private static $_controllerObject;

    /**
     * 执行路由动作
     * @return NULL
     */
    public static function route()
    {
        self::_parseUri();
        self::_route();
        self::_execute();
        self::_render();
    }

    /**
     * 解析请求URI，计算控制器
     * @return NULL
     */
    private static function _parseUri()
    {
        $uri = Core_Context::getUri();
        self::$_controller = trim($uri, '/');
        if (empty(self::$_controller)) {
            self::$_controller = self::$_defaultController;
        }
    }

    /**
     * 路由到特定控制器类
     * @return NULL
     */
    private static function _route()
    {
        $pieces = explode('/', self::$_controller);

        // 应用特殊路由规则，获取controller和param，param放到context中
        $pieces = self::_applyRouteRules($pieces);

        $pieces = array_map('ucfirst', $pieces);
        self::$_controllerClass = implode('_', $pieces);
        unset($pieces);

        self::$_controllerClass = self::$_controllerClassPrefix . self::$_controllerClass;
        if (!class_exists(self::$_controllerClass) || 'Controller_Abstract' == self::$_controllerClass) {
            self::$_controllerClass = 'Controller_404';
        }
    }

    /**
     * 实例化控制器，并执行控制器
     * @return NULL
     */
    private static function _execute()
    {
        $class = new ReflectionClass(self::$_controllerClass);
        self::$_controllerObject = $class->newInstance();
        $class->getMethod('execute')->invoke(self::$_controllerObject);
    }

    /**
     * 渲染输出
     * @return NULL
     */
    private static function _render()
    {
        $rend = self::$_controllerObject->render();

        if ($rend['type'] == 'html') {
            $res = Util_Smarty::display($rend['template'], $rend['data']);
            if (!$res) {
                header('Location: /404');
            }
        } elseif ($rend['type'] == 'json') {
            echo json_encode($rend['data']);
        } elseif ($rend['type'] == 'text') {
            echo is_string($rend['data']) ? $rend['data'] : 'Invalid Data';
        } elseif ($rend['type'] == 'none') {
            // do nothing
        } else {
            header('Location: /404');
        }
    }

    /**
     * 应用特殊路由规则
     */
    private static function _applyRouteRules($pieces)
    {
        return $pieces;
    }
}
