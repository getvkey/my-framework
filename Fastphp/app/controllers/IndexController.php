<?php
namespace app\controllers;

use fastphp\base\Controller;

class IndexController extends Controller
{
    use BaseTrait;

    public function index()
    {
        
        return $this->returnJson(1, '获取数据成功', ['name' => 'peter', 'addr' => 'shenzhen']);
    }
}