<?php

namespace App\AbstractFactory\Tests;

// use PHPUnit\Framework\TestCase;
use App\AbstractFactory\AbstractFactory;
use App\AbstractFactory\HtmlFactory;
use App\AbstractFactory\JsonFactory;

/**
 * AbstractFactoryTest 用于测试具体的工厂
 */
class AbstractFactoryTest extends \PHPUnit\Framework\TestCase
// class AbstractFactoryTest extends \PHPUnit_Framework_TestCase
// class AbstractFactoryTest extends TestCase
{
    public function getFactories()
    {
        /*return [
            [new JsonFactory()],
            [new HtmlFactory()]
        ];*/
        return array(array(new JsonFactory()), array(new HtmlFactory()));
    }

    /**
     * 这里是工厂的客户端，我们无需关心传递过来的是什么工厂类
     * 只需以我们想要的方式渲染任意想要的组件即可
     *
     * @param AbstractFactory $factory
     * @return void
     */
    public function testComponentCreation(AbstractFactory $factory)
    {
        $article = [
            $factory->createText('Laravel学院'),
            $factory->createPicture('./image.png', 'Laravel-academy'),
            $factory->createText('LaravelAcademy.org')
        ];

        $this->assertContainsOnly('App\AbstractFactory\MediaInterface', $article);
    }
}