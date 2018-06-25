<?php

namespace Products;


abstract class Products
{
    protected $title;
    protected $price;
    protected $make = '-';
    protected $model = '-';
    public static $staticProperty = 0;

    public function __construct($title, $price)
    {
        $this->title = $title;
        $this->price = $price;
        self::$staticProperty++;
    }

    public function getProperty()
    {
        echo self::$staticProperty;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setMake($make)
    {
        $this->make = $make;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function printFullDescription()
    {
        echo '<i>Category: </i> ' . $this->title . ', <i>Name: </i> ' . $this->make . ', <i>Model: </i> ' . $this->model . ',
            <i>Price: </i> ' . $this->getPrice();
        $this->printDescription();
    }

    abstract public function printDescription();
}