<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Задание к лекции "Обработка форм"</title>
        <meta name="description" content="Нетология. Курс PHP/SQL. Урок 2.2">
    </head>
    <body>
    <ul>
        <li><a href="admin.php">Загрузчик тестов</a></li>
        <li><a href="list.php">Список загруженных тестов</a></li>
    </ul>
    <?php
    $file_list = glob(__DIR__ . '/uploads/*.json');
    $test = [];
    $result = '';

    foreach ($file_list as $key => $file) {
        if ($key == @$_GET['test']) {
            $test = json_decode(file_get_contents($file_list[$key]), true);
            $test_name = pathinfo($file)['filename'];
            echo "<h3>$test_name</h3>";
        }
    }

    $q = $test[0]['q'];
    $answers[] = $test[0]['ans'];

    if (count($_POST) != 0) {
        foreach ($answers[0] as $answer) {
            if ($answer['a'] == $_POST[$test_name]) {
                if ($answer['r']) {
                    $result = 'Правильно, это ' . $answer['a'];
                    break;
                } else $result = 'Не правильно, это не ' . $answer['a'];
            }
        }
    }
    ?>
    <form action="" method="post">
        <fieldset>
            <legend><?=$q?></legend>
            <?php foreach ($answers[0] as $key => $answer) : ?>
                <label><input type="radio" name="<?=$test_name;?>" value="<?=$answer['a'];?>"> <?=$answer['a'];?></label>
            <?php endforeach; ?>
        </fieldset>
        <input type="submit" value="Отправить">
    </form>
    <br>
    <?php echo $result; ?>
    </body>
</html>