<?php

namespace App\AbstractFactory;

/**
 * Text类
 */
abstract class Text implements MediaInterface
{
    /**
     * @var string
     */
    protected $text;

    /**
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }
}