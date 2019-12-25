<?php

namespace app\controllers;

use fastphp\base\Controller;
use app\models\Item;

class ItemController extends Controller
{
    /**
     * 首页方法测试框架自定义DB查询
     * 模型类引用
     * 如果用注入方式，之前的实例过的数据都会保留存在
     * 用new重新引用
     */
    public function index()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

        if ($keyword) {
            $items = (new Item())->search($keyword);
        } else {
            $items = (new Item())->where()->order(['id DESC'])->fetchAll();
        }

        $this->assign('title', '全部条目');
        $this->assign('keyword', $keyword);
        $this->assign('items', $items);

        $this->render();
    }

    /**
     * 详情
     *
     * @param int $id
     */
    public function detail(int $id)
    {
        $item = (new Item())->where(["id = ?", [$id]])->fetch();

        $this->assign('title', '条目详情');
        $this->assign('item', $item);

        $this->render();
    }

    /**
     * 添加
     *
     */
    public function add()
    {
        $data['item_name'] = $_POST['value'];
        $count = (new Item())->add($data);

        $this->assign('title', '添加成功');
        $this->assign('count', $count);

        $this->render();
    }

    /**
     * 管理
     *
     * @param int $id
     */
    public function manage($id = 0)
    {
        $item = [];
        if ($id) {
            $item = (new Item())->where(['id = :id'], [':id' => $id])->fetch();
        }

        $this->assign('title', '管理条目');
        $this->assign('item', $item);

        $this->render();
    }

    /**
     * 更新
     *
     */
    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'item_name' => $_POST['value']
        ];

        $count = (new Item())->where(['id = :id'], [':id' => $data['id']])->update($data);

        $this->assign('title', '修改成功');
        $this->assign('count', $count);

        $this->render();
    }

    /**
     * 删除
     *
     * @param null $id
     */
    public function delete($id = null)
    {
        $count = (new Item())->delete($id);

        $this->assign('title', '删除成功');
        $this->assign('count', $count);

        $this->render();
    }

}