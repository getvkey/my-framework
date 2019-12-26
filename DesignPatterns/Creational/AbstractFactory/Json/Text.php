<?php

namespace App\AbstractFactory\Json;

use App\AbstractFactory\Text as BaseText;

/**
 * Text类
 * 
 * 该类是以 JSON 格式输出的具体文本组件类
 */
class Text extends BaseText
{
    /**
     * 以 JSON 格式输出的渲染
     *
     * @return false|string|void
     */
    public function render()
    {
        return json_encode([
            'content' => $this->text
        ]);
    }
}