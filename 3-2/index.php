<?php
//1. Полиморфизм — возможность объектов с одинаковой спецификацией иметь различную реализацию.
// Наследование позволяет создавать новые классы на основе существующих, принимая свойства и методы родительского класса
// и дополняя их новыми.
//2. Абстрактный класс, не предназначенный для создания экземпляров (объектов), позволяет задать базовые абстрактные
// принципы с минимальным содержанием для последующей их конкретизации и наполнения в классах наследниках. Но так же
// может содержать конкретные реализации (рабочие методы). Интерфейсы в отличии от абстрактных классов могут содержать
// лишь абстрактные методы и не имеют свойств. Для методов интерфейсов определяется конкретная сигнатура, в соответствии
// с которой классы реализовывают их.
// Применение абстрактных классов имеет смысл для создания базового уровня проектирования, когда понятна задача но не
// определена конкретная реализация. Интерфейсы же добавляют методы с обязательными элементами для реализации в разных
// несвязаных классах.

//3, 4.
class Goods
{
    public $color;
    public $price;

    public function __construct($color, $price)
    {
        $this->color = $color;
        $this->price = $price;
    }
}

interface ChangeColor
{
    public function changeColor($color);
}

class Car extends Goods implements ChangeColor
{
    public function __construct()
    {
        parent::__construct('white', '100000');
    }

    public function changeColor($color)
    {
        $this->color = $color;
        $this->price += 100;
    }
}

$car1 = new Car();
$car2 = new Car();

$car1->changeColor('red');

var_dump($car1);
echo '<br>';
var_dump($car2);
echo '<br>';

class Tv extends Goods
{
    public $model;
    public $diagonal;

    public function __construct($color, $price, $model, $diagonal)
    {
        parent::__construct($color, $price);
        $this->model = $model;
        $this->diagonal = $diagonal;
    }
}

$lg = new Tv('silver', 1500,'LG', 32);
$samsung = new Tv('black', 2000, 'Samsung', 40);

var_dump($lg);
echo '<br>';
var_dump($samsung);
echo '<br>';

class Pen extends Goods implements ChangeColor
{
    public $brand;

    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    public function changeColor($color)
    {
        $this->color = $color;

    }
}

$parker = new Pen('Parker');
$waterman = new Pen('Waterman');
$parker->changeColor('blue');

echo $parker->brand . ' is ' . $parker->color;
echo '<br><hr>';


//Extra

class Products
{
    public $title;
    public $category;
    public $description;
    public $weight;
    public $price;
    public $discount;
    public $delivery;

    public function __construct($title, $category, $price, $weight)
    {
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->weight = $weight;
        echo "Product:  $this->title";
    }

    public function getPrice()
    {
        echo "<br>Price: {$this->price}";
    }

    public function getDiscountPrice()
    {
        $this->discount = 10;
        $this->priceDisc = round(($this->price - $this->price * $this->discount / 100), 2);
        echo "<br>Sale: {$this->priceDisc}, discount: {$this->discount}%";
    }
}

trait getWeightDiscount
{
    public function getWeightDiscount()
    {
        if ($this->weight > 10) {
            $this->discount = 10;
            $this->priceDisc = round($this->price - ($this->price * $this->discount / 100));
            echo "<br>Sale: {$this->priceDisc}, discount: {$this->discount}%";
        } else {
            $discount = 0;
            echo "<br>Price: {$this->price}";
        }
    }
}

trait getDelivery
{
    public function getDeliveryPrice()
    {
        if ($this->discount == 0) {
            $this->delivery = 250;
        } else {
            $this->delivery = 300;
        }
        echo "<br>Delivery: {$this->delivery}";
    }
}

class Pens extends Products
{
    use getDelivery;
}

$pen = new Pens("Parker", "Pens", 1000, 0.1);
echo $pen->getDiscountPrice();
echo $pen->getDeliveryPrice() . "<br><hr>";

class Phones extends Products
{
    use getDelivery;
}

$phone = new Phones("iPhone", "Phones", 3000, 0.2);
echo $phone->getPrice();
echo $phone->getDeliveryPrice() . "<br><hr>";

class Appliances extends Products
{
    use getDelivery, getWeightDiscount;
}

$tv = new Appliances("Samsung", "Tv", 2000, 15);
echo $tv->getWeightDiscount();
echo $tv->getDeliveryPrice() . "<br><hr>";