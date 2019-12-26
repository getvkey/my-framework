<?php

namespace App\AbstractFactory;

/**
 * Picture类
 */
abstract class Picture implements MediaInterface
{
    /**
     * 路径
     *
     * @var string
     */
    protected $path;

    /**
     * 名称
     *
     * @var string
     */
    protected $name;

    /**
     * 构造方法
     *
     * @param string $path
     * @param string $name
     */
    public function __construct(string $path, $name = '')
    {
        $this->name = $name;
        $this->path = $path;
    }
}
