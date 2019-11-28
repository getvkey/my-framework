<?php

namespace app\models;

use fastphp\base\Model;
use fastphp\db\Db;

class Item extends Model
{
    /**
     * 自定义当前模型的数据表名称
     * 如果不指定默认为类名称的小写字符串
     *
     * @var string
     */
    protected $table = 'item';

    /**
     * 搜索功能，因为Sql父类没有现成的like搜索
     * 所有需要自己写sql语句，对数据库的操作都应该在Model层处理，然后提供给Controller层调用
     *
     * @param string $keyword
     * @return mixed
     */
    public function search(string $keyword)
    {
        $sql = "select * from `$this->table` where `item_name` like :keyword";
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [':keyword' => "%$keyword%"]);
        $sth->execute();

        return $sth->fetchAll();
    }
}