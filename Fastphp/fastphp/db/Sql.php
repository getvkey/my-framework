<?php

namespace fastphp\db;

use \PDOStatement;

class Sql
{
    // 数据库表名
    protected $table;

    // 数据表主键
    protected $primary = 'id';

    // where和order拼装后的条件
    private $filter = '';

    // Pdo bindParam() 绑定的参数集合
    private $param = [];

    /**
     * 拼接查询条件
     * $this->>where(['id' => 1, "and title = `hello`", ])->fetch()
     * 为了防止注入，建议通过$param方式传入参数
     * $this->where(['id' => ':id'], [':id' => $id])->fetch()
     *
     * @param array $where
     * @param array $param
     * @return Sql
     */
    public function where($where = [], $param = [])
    {
        if ($where) {
            $this->filter .= ' WHERE ';
            $this->filter .= implode(' ', $where); // 把数组转换字符串空格分隔
            $this->param = $param;
        }

        return $this;
    }

    /**
     * 拼装排序条件
     * $this->>order(['id DESC', 'title DESC'])->fetch()
     *
     * @param array $order
     * @return $this
     */
    public function order($order = [])
    {
        if ($order) {
            $this->filter .= ' ORDER BY ';
            $this->filter .= implode(',', $order);
        }

        return $this;
    }

    /**
     * 查询所有
     *
     * @return array
     */
    public function fetchAll()
    {
        $sql = sprintf("select * from `%s` %s", $this->table, $this->filter);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * 查询一条
     *
     * @return mixed
     */
    public function fetch()
    {
        $sql = sprintf("select * from `%s` %s", $this->table,$this->filter);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->fetch();
    }

    /**
     * 根据条件（id）删除
     *
     * @param int $id
     * @return int
     */
    public function delete(int $id)
    {
        $sql = sprintf("delete from `%s` where `%s` = :%s", $this->table, $this->primary, $this->primary);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, [$this->primary => $id]);
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * 新增数据
     *
     * @param $data
     * @return int
     */
    public function add($data)
    {
        $sql = sprintf("insert into `%s` %s", $this->table, $this->formatInsert($data));
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $data);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * 更新数据
     *
     * @param $data
     * @return int
     */
    public function update($data)
    {
        $sql = sprintf("update `%s` set %s %s", $this->table, $this->formatUpdate($data), $this->filter);
        $sth = Db::pdo()->prepare($sql);
        $sth = $this->formatParam($sth, $data);
        $sth = $this->formatParam($sth, $this->param);
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * 占位符绑定具体的变量值
     *
     * @param PDOStatement $sth 要绑定的PDOStatement对象
     * @param array $params 参数，有三种类型：
     * 1）如果SQL语句用问号？占位符，那么$params应该为：
     *    [$a, $b, $c]
     * 2）如果SQL语句用冒号：占位符，那么$params应该为：
     *    ['a' => $a, 'b' => $b, 'c' => $c]
     *    或者
     *    [':a' => $a, ':b' => $b, ':c' => $c]
     * @return PDOStatement
     */
    public function formatParam(PDOStatement $sth, $params = [])
    {
        foreach ($params as $param => &$value) {
            $param = is_int($param) ? $param + 1 : ':' . ltrim($param, ':');
            $sth->bindParam($param, $value);
        }

        return $sth;
    }

    /**
     * 将数组转换成插入格式的sql语句
     *
     * @param $data
     * @return string
     */
    public function formatInsert($data)
    {
        $fields = [];
        $names = [];

        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $names[] = sprintf(":%s", $key);
        }

        $field = implode(',', $fields);
        $name = implode(',', $names);

        return sprintf("(%s) values (%s)", $field, $name);
    }

    /**
     * 将数组转换成更新格式的sql语句
     *
     * @param $data
     * @return string
     */
    public function formatUpdate($data)
    {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s` = :%s", $key, $key);
        }

        return implode(',', $fields);
    }
}