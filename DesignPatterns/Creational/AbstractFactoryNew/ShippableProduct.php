<?php

namespace App\AbstractFactoryNew;

class ShippableProduct implements Product
{
    /**
     * @var float
     */
    private $productPrice;

    /**
     * @var float
     */
    private $shippingCosts;

    public function __construct(int $productPrice, int $shippingCosts)
    {
        $this->productPrice = $productPrice;
        $this->shippingCosts = $shippingCosts;
    }

    public function calculatePrice(): int
    {
        // TODO: Implement calculatePrice() method.
        return $this->productPrice + $this->shippingCosts;
    }
}