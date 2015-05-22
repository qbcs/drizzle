<?php
/**
 * 控制器的抽象基类，所有业务控制器类都要继承此类
 * @since 2015-01-02 19:03:05
 */

abstract class Controller_Abstract
{
    protected $_runData   = array();
    protected $_renderType = 'html';
    protected $_template  = '';

    function __construct()
    {
        $this->init();
    }

    public function init()
    {
    }

    public function execute()
    {
        $this->_runData = $this->run();
    }

    abstract function run();

    public function render()
    {
        return array(
            'type'      => $this->_renderType,
            'template'  => $this->_template,
            'data'      => $this->_runData,
            );
    }
}
