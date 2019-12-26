<?php

namespace App\AbstractFactory;

/**
 * JsonFactory
 * 
 * JsonFactory 是用于创建 JSON 组件的工厂
 */
class JsonFactory extends AbstractFactory
{
    /**
     * 创建图片组件
     *
     * @param string $path
     * @param string $name
     * @return Json\Picture
     */
    public function createPicture(string $path, $name = '')
    {
        return new Json\Picture($path, $name);
    }

    /**
     * 创建文本组件
     *
     * @param string $content
     * @return Json\Text
     */
    public function createText(string $content)
    {
        return new Json\Text($content);
    }
}