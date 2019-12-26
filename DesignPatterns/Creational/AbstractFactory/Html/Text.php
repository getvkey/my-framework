<?php

namespace App\AbstractFactory\Html;

use App\AbstractFactory\Text as BaseText;

/**
 * Text类
 * 
 * 该类是以 HTMl 格式渲染的具体文本组件类
 */
class Text extends BaseText
{
    /**
     * 以 HTML 格式渲染
     *
     * @return string|void
     */
    public function render()
    {
        return '<div>' . htmlspecialchars($this->text) . '</div>';
    }
}