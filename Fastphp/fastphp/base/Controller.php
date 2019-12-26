<?php

namespace fastphp\base;

/**
 * 控制器基类
 *
 * Class Controller
 * @package fastphp\base
 */
class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

    /**
     * 构造函数，初始化属性，并实例化对应模型
     * Controller constructor.
     * @param $controller
     * @param $action
     */
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

    /**
     * 分配变量，保存到View对象
     *
     * @param $name
     * @param $value
     */
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    /**
     * 渲染视图
     */
    public function render()
    {
        $this->_view->render();
    }

    /**
     * 返回json格式
     *
     * @param integer $code
     * @param string $msg
     * @param array $data
     * @return void
     */
    public function returnJson(int $code, string $msg, array $data)
    {
        $this->_view->returnJson($code, $msg, $data);
    }
}