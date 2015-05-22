<?php
/**
 * 404控制器
 * @since 2015-01-03 02:32:36
 */

class Controller_404 extends Controller_Abstract
{
    public function init()
    {
        $this->_renderType = 'text';
    }

    public function run()
    {
        return '<h1>404 NOT FOUND - Drizzle</h1>';
    }
}
