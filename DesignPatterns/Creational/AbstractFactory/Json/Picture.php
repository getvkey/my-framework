<?php

namespace App\AbstractFactory\Json;

use App\AbstractFactory\Picture as BasePicture;

/**
 * Picture类
 * 
 * 该类是以 JSON 格式输出的具体图片组件类
 */
class Picture extends BasePicture
{
    /**
     * JSON 格式输出
     *
     * @return false|string|void
     */
    public function render()
    {
        return json_encode([
            'title' => $this->name,
            'path' => $this->path
        ]);
    }

}