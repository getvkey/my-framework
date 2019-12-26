<?php
namespace app\controllers;

trait BaseTrait
{

    /**
     * 返回json格式
     *
     * @param integer $code
     * @param string $msg
     * @param array $data
     * @return void
     */
    protected function returnJson(int $code, string $msg, array $data)
    {
        return json_encode([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }
}