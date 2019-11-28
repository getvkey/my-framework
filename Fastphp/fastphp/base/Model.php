<?php

namespace fastphp\base;

use fastphp\db\Sql;

/**
 * 模型基类
 *
 * Class Model
 * @package fastphp\base
 */
class Model extends Sql
{
    protected $model;

    public function __construct()
    {
        // 判断数据表是否存在
        if (!$this->table) {

            // 获取模型类名称
            $this->model = get_class($this);

            // 删除类名最后的Model字符
            $this->model = substr($this->model, 0, -5);

            // 转小写
            $this->model = strtolower($this->model);
        }
    }
}