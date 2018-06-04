<?php

namespace Cart;

class Order
{
    private $order;
    public function __construct(Cart $cart)
    {
        $this->order = $cart;
    }
    public function getInfoOrder()
    {
        $i = 1;
        foreach ($this->order->container as $key=>$product) {
            echo $i . ' ';
            $this->order[$key]->printFullDescription();
            $i++;
            echo '<br>';
        }
    }
}