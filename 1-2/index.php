<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title><?= "$name - "?>Ряд Фибоначчи</title>
        <meta name="description" content="Нетология. Урок 1.2">
    </head>
    <body>
        <h3>Проверка числа на принадлежность ряду Фибоначчи</h3>
        <?php
            $userNumber = rand(0,100);
            $firstNumber = 1;
            $secondNumber = 1;

            echo '<p> Проверяемое число = '.$userNumber.'</p>';

            while (true) {
                if ($firstNumber > $userNumber) {
                    echo '<p>Проверяемое число НЕ входит в данный числовой ряд<p>';
                    break;
                }
                else if ($firstNumber === $userNumber) {
                    echo '<p>Проверяемое число входит в данный числовой ряд<p>';
                    break;
                }
                else {
                    $thirdNumber = $firstNumber;
                    $firstNumber = $firstNumber + $secondNumber;
                    $secondNumber = $thirdNumber;
                }
            }
        ?>
    </body>
</html>