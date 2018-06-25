<?php
//1. Пространства имен один из способов инкапсуляции элементов. Простыми словами, аналогом пространства имен являются
// директории в операционной системе, служащие для группировки связанных файлов. Пространства имен в PHP позволяют
// организовывать библиотеки избегая конфликтов имен между разрабытываемым кодом и различными классами (функциями,
// константами), внутренними и  сторонними, а так же дают возможность использовать псевдонимы (сокращения) для длинных
// имен.
// 2. Exception — это базовый класс для всех исключений в PHP, исключение выбрасывается в случае возникновения
// нештатной ситуации, когда функция обнаруживает что не способна выполнить свою задачу. В PHP есть встроенные классы
// исключений, так же возможно написание собственных. Исключения можно отлавливать для их последующей обработки.
// Другими словами, exception это исключительные ситуации, когда невозможно выполнить код в задуманном виде, и для
// этих ситуаций существует механизм перехвата для последующей обработки.

// 3 .. 6 & Extra.

spl_autoload_register(
    function ($className) {
        $fullPath = 'assets' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        if (file_exists($fullPath)) {
            require $fullPath;
        }
    }
);

$pen = new  Products\Pens\Pens('Pen', 100);
$pen->setColor('blue');
$pen->setMake('Parker');

$phone = new Products\Phones\Phones('Phone', 3000);
$phone->setMake('Apple');
$phone->setModel('iPhone');
$phone->setLte();

$tv = new Products\Appliances\Appliances('TV', 2000);
$tv->setMake('Samsung');
$tv->setModel('32v6');
$tv->setSize(32);


$cart = new Cart\Cart();
$cart[] = $pen;
$cart[] = $phone;
$cart[] = $tv;
echo "<h3>Total: {$cart->getPriceProductsCart()}</h3>";

$order = new Cart\Order($cart);
$order->getInfoOrder();

echo '<br><hr>';

unset($cart[0]);
echo "<h3>Total: {$cart->getPriceProductsCart()}</h3>";

$order = new Cart\Order($cart);
$order->getInfoOrder();