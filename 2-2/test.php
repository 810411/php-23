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
$result = 0;
$info = '';

foreach ($file_list as $key => $file) {
    if ($key == @$_GET['test']) {
        $test = json_decode(file_get_contents($file_list[$key]), true);
        $test_name = pathinfo($file)['filename'];
    }
}

foreach ($test as $key => $value) {
    $questions[] = $value['q'];
    $answers[] = $value['ans'];
}

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        foreach ($answers[$key] as $answer) {
            if ($value == $answer['a']) {
                if ($answer['r']) {
                    $result++;
                }
            }
        }
    }
}

if ($result > 0) {
    $suffix = ($result == 1 ? '' : 'а');
    $info = 'Вы ответили правильно на ' . $result . ' вопрос' . $suffix;
    $result = 0;
} else if (!empty($_POST)) {
    $info = 'Вы ответили неправильно';
}
?>
<h3><?= $test_name ?></h3>
<form action="" method="post">
    <?php for ($i = 0; $i < count($questions); $i++) : ?>
        <fieldset>
            <legend><?= $questions[$i]; ?></legend>
            <?php foreach ($answers[$i] as $a => $answer) : ?>
                <label><input type="radio" name="<?= $i; ?>"
                              value="<?= $answer['a']; ?>"> <?= $answer['a']; ?>
                </label>
            <?php endforeach; ?>
        </fieldset>
    <?php endfor; ?>
    <input type="submit" value="Отправить">
</form>
<br>
<?php echo $info; ?>
</body>
</html>