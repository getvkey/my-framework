<?php
require './../vendor/autoload.php';

// namespace App\AbstractFactoryNew\Tests;



use App\AbstractFactoryNew\DigitalProduct;
use App\AbstractFactoryNew\ProductFactory;
use App\AbstractFactoryNew\ShippableProduct;



$factory = new ProductFactory();
$product = $factory->createDigitalProduct(150);
print_r($product->calculatePrice());
