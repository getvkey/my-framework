<?php
require '../../../vendor/autoload.php';

// namespace App\AbstractFactory\Tests;

use App\AbstractFactory\AbstractFactory;
use App\AbstractFactory\HtmlFactory;
use App\AbstractFactory\JsonFactory;
use App\AbstractFactory\Json\Picture;

/*class TestsFactory
{
    protected $factory;

    protected $jsonFactory;

    public $arrData = [];

    public function __construct()
    {
        $this->jsonFactory = new JsonFactory();
        $article = [
            $this->jsonFactory->createText('Laravel学院'),
            $this->jsonFactory->createPicture('./image.png', 'Laravel-academy'),
            $this->jsonFactory->createText('LaravelAcademy.org')
        ];

        // return $article;
        print_r($article);
    }


}*/

$jsonData = new JsonFactory();
$jsonData = $jsonData->createPicture('/var/images/logo.jpg', 'logo');
print_r($jsonData->render());

echo PHP_EOL;

$htmlData = new HtmlFactory();
$htmlData = $htmlData->createPicture('/index/img.jpg', 'peter');
print_r($htmlData->render());

echo PHP_EOL;

$htmlData = new HtmlFactory();
$htmlData = $htmlData->createText('/index/img.jpg');
print_r($htmlData->render());