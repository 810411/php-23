<?php

namespace Products\Pens;

use Products\Products;

class Pens extends Products
{
    private $color = '-';
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function printDescription()
    {
        echo ', <i>Color: </i> '.$this->color;
    }
}