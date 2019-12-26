<?php

namespace App\AbstractFactory;

/**
 * 抽象工厂
 * 
 * 该设计模式实现了设计模式的依赖倒置原则，因为最终由具体子类创建具体组件
 * 
 * 在本例中，抽象工厂为创建 Web 组件（产品）提供了接口，这里由两个组件：文本和图片，有两种渲染方式：HTML
 * 和 JSON，对应四个具体实现类。
 */
abstract class AbstractFactory
{
    /**
     * 创建文本组件
     *
     * @param string $content
     * @return mixed
     */
    abstract public function createText(string $content);

    /**
     * 创建图片组件
     *
     * @param string $path
     * @param string $name
     * @return mixed
     */
    abstract public function createPicture(string $path, $name = '');

}