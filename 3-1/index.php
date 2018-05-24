<?php
//1. Инкапсуляция - один из основополагающих принципов ООП, подразумевающий, в рамках программы, выделение отдельных
//компонентов и данных в условную оболочку для ограничения доступа от остальных компонентов и внешнего воздействия.
//Так же в рамках этой оболочки доступна организация взаимосвязи внутренних данных и компонентов, прав доступа к ним
// из вне.

//2. К плюсам объектов можно отнести сам объектно-ориентированный подход в целом - отделение от основного кода программы
//изолированных блоков - классов, на основе которых возможно создание объектов по шаблону с возможностью переопределения
//свойств и гибким использованием заранее заложенных методов. Т.е. в отличии от функции можно не только выделить
// повторяющийся код, но и сделать его более гибким, изменяемым по контексту, при этом защитив его модифицированные
// копии друг от друга.
//Минус такого подхода в высоком пороге вхождения для начинающих разработчиков, слабая применимость для простых задач.

//3

class Car
{
    public $color = 'white';
    public $price = '10000';

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

class Tv
{
    public $model;
    public $diagonal;
    public $price;

    public function __construct($model, $diagonal, $price)
    {
        $this->model = $model;
        $this->diagonal = $diagonal;
        $this->price = $price;
    }

}

$lg = new Tv('LG', '32', '200');
$samsung = new Tv('Samsung', '40', '250');

var_dump($lg);
echo '<br>';
var_dump($samsung);
echo '<br>';

class Pen
{
    private $color = 'blue';
    public $brand;

    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    public function getColor()
    {
        return $this->color;
    }
}

$parker = new Pen('Parker');
$waterman = new Pen('Waterman');

echo $parker->brand . ' is ' . $parker->getColor();
echo '<br>';

class Duck
{
    public $name = 'Donald ';
    public static $count = 0;

    public function __construct($name)
    {
        $this->name .= $name;
        self::$count++;
    }
}

$duck = new Duck('Duck');
echo '№' . Duck::$count . ' ' . $duck->name;
echo '<br>';

$trump = new Duck('Trump');
echo '№' . Duck::$count . ' ' . $trump->name;
echo '<br>';

class Commodity
{
    public $name = 'Product';
    public static $count = 10;

    public function purchased($count)
    {
        if (self::$count >= $count) {
            self::$count -= $count;
            echo $count . ' ' . $this->name . ' purchased';
        } else echo 'Insufficient quantity of ' . $this->name;
    }
}

$product = new Commodity();

echo $trump->name . ' tries to buy 7 ' . $product->name;
echo '<br>';
$product->purchased(7);
echo '<br>';

echo $trump->name . ' tries to buy 5 ' . $product->name;
echo '<br>';
$product->purchased(5);
echo '<br>';

//Extra

class News
{
    private $title;
    private $article;
    public static $count = 0;

    public function __construct($title, $article)
    {
        $this->title = $title;
        $this->article = $article;
    }

    public function setArticle($article)
    {
        $this->article = $article;
    }

    public function getNews()
    {
        self::$count++;
        echo '<h3>' . News::$count . '. ' . $this->title . '</h3>';
        echo '<p>' . $this->article . '<p>';
    }
}

$news1 = new News('What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting 
industry.');
$news2 = new News('Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random
 text.');
$news3 = new News('Why do we use it?', 'It is a long established fact that a reader will be distracted by 
the readable content of a page when looking at its layout.');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Задание к занятию «Классы и объекты»</title>
    <meta name="description" content="Нетология. Занятие 3.1. Классы и объекты">
</head>
<body>
<h2>News</h2>
<?php
$news1->getNews();
$news2->getNews();
$news3->getNews();
?>
</body>
</html>