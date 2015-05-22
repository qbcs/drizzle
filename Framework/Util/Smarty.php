<?php
/**
 * Smarty工具类
 * @since 2015-01-04 00:51:30
 */

class Util_Smarty
{
    /**
     * 渲染html
     * @param  string $template 模板路径
     * @param  array $data      模板数据
     * @return bool
     */
    public static function display($template, $data)
    {
        if (!file_exists(TEMPLATE_DIR . DS . $template)) {
            return false;
        }

        require_once FRM_T3PARTY_DIR . DS . 'Smarty-3.1.18' . DS . 'libs' . DS . 'Smarty.class.php';
        $_compileDir = rtrim(Core_Context::getServer('DATA_DIR', '/tmp'), DS) . DS . 'smarty_compiles';
        if (!file_exists($_compileDir)) {
            mkdir($_compileDir, 0777, TRUE);
        }

        $smarty = new Smarty;
        // $smarty->debugging = true;
        // $smarty->caching = true;
        // $smarty->cache_lifetime = 120;
        $smarty->__set('compile_dir', $_compileDir);
        $smarty->assign($data);
        $smarty->display(TEMPLATE_DIR . DS . $template);
        return true;
    }
}