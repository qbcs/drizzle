<?php
/**
 * Demo项目默认控制器
 * @since 2015-01-03 02:03:32
 */

class Controller_Index extends Controller_Abstract
{
    /**
     * 初始化，设置:
     *     $this->_template 模板路径，使用Smarty作为模板引擎
     *     $this->_renderType 渲染类型，默认为'html'(输出html)，还可设置为'json'(输出json串，一般用于接口)
     * @return NULL
     */
    public function init()
    {
        $this->_template = 'index.phtml';
    }

    /**
     * 控制器的逻辑部分
     * @return array 计算出页面或者接口要展现的数据
     */
    public function run()
    {
        return array(
            'title' => '欢迎 - Drizzle',
            'msg'   => '欢迎使用Drizzle框架',
            );
    }
}
