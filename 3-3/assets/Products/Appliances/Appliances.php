<?php

namespace Products\Appliances;

use Products\Products;

class Appliances extends Products
{
    private $size = '-';
    public function setSize($size)
    {
        $this->size = $size;
    }
    public function printDescription()
    {
        echo ', <i>Size: </i> '.$this->size;
    }
}