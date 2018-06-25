<?php

namespace Cart;

class Cart implements \ArrayAccess //Интерфейс обеспечивает доступ к объектам в виде массивов.
{
    public $container = [];

    public function offsetSet($index, $product)
    {
        try {
            if (empty($product->getPrice())) {
                throw new MyException('<b>Error</b> ');
            }
            if (is_null($index)) {
                $this->container[] = $product;
            } else {
                $this->container[$index] = $product;
            }
        } catch (MyException $e) {
            echo $e->getMessage(), $product->printFullDescription(), '<b> price not determined';
        }
    }

    public function offsetGet($index)
    {
        return isset($this->container[$index]) ? $this->container[$index] : null;
    }

    public function offsetExists($index)
    {
        return isset($this->container[$index]);
    }

    public function offsetUnset($index)
    {
        unset($this->container[$index]);
    }

    public function getPriceProductsCart()
    {
        $totalPrice = 0;
        foreach ($this->container as $product) {
            $totalPrice = $totalPrice + $product->getPrice();
        }
        return $totalPrice;
    }
}