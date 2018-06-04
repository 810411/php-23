<?php

namespace Products\Phones;

use Products\Products;

class Phones extends Products
{
    private $lteOn = '-';
    public function setLte()
    {
        $this->lteOn = '+';
    }
    public function printDescription()
    {
        echo ', <i>LTE: </i> '.$this->lteOn;
    }
}