<?php

namespace App\AbstractFactory;

/**
 * HtmlFactory类
 * 
 * HtmlFactory 是用于创建 HTML 组件的工厂
 */
class HtmlFactory extends AbstractFactory
{
    /**
     * 创建图片组件
     *
     * @param string $path
     * @param string $name
     * @return Html\Picture
     */
    public function createPicture(string $path, $name = '')
    {
        return new Html\Picture($path, $name);
    }

    /**
     * 创建文本组件
     *
     * @param string $content
     * @return Html\Text
     */
    public function createText(string $content)
    {
        return new Html\Text($content);
    }
}