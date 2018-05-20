<?php
$fileList = glob(__DIR__ . '/uploads/*.json');
$test = [];
$result = 0;
$info = '';

foreach ($fileList as $key => $file) {
    if ($key == @$_GET['test']) {
        $test = json_decode(file_get_contents($fileList[$key]), true);
        $testName = pathinfo($file)['filename'];
    }
}

if (!isset($test[0]['q'])) {
    http_response_code(404);
    echo '404. Not Found <br>';
    echo 'В файле ' . $testName . ' тестов не найдено';
    echo '<br><a href="list.php">Список загруженных тестов</a>';
    exit(0);
}

foreach ($test as $key => $value) {
    $questions[] = $value['q'];
    $answers[] = $value['ans'];
}

if (!empty($_POST)) {
    $user = $_POST['user'];
    $userAnswers = array_slice($_POST, 0, -4);
    foreach ($userAnswers as $key => $value) {
        foreach ($answers[$key] as $answer) {
            if ($value == $answer['a']) {
                if ($answer['r']) {
                    $result++;
                }
            }
        }
    }
    if ($result > 0) {
        $texts[] = 'от ' . date("d-m-Y");
        $texts[] = 'удостоверяет, что';
        $texts[] = $_POST['user'];
        $texts[] = 'прошел ' . $testName;
        $texts[] = 'ответив вопросов ' . $result . ' из ' . count($questions);

        $path = __DIR__ . '/images/sert.png';
        $img = imagecreatefrompng($path);
        $font = __DIR__ . '/images/SegoeUI.ttf';
        $black = imagecolorallocate($img, 0, 0, 0);
        $imageSize = getimagesize($path);
        $y = $imageSize[1] / 3;

        foreach ($texts as $text) {
            $textPoints = imagettfbbox(20, 0, $font, $text);
            $pos = ($imageSize[0] - $textPoints[2] - $textPoints[0]) / 2;
            imagettftext($img, 20, 0, $pos, $y += 40, $black, $font, $text);
        }
        imagettftext($img, 20, 0, $imageSize[0] / 2 + $imageSize[0] / 4,
            $imageSize[1] - $imageSize[1] / 5, $black, $font, "В.В.");

        header('Content-type: image/png');
        imagepng($img);
        imagedestroy($img);
        exit(0);

    } else if (!empty($_POST)) {
        $info = $_POST['user'] . ', вы ответили неправильно';
    }
}
?>
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
<h3><?= $testName ?></h3>
<form action="" method="POST">
    <?php for ($i = 0; $i < count($questions); $i++) : ?>
        <fieldset>
            <legend><?= $questions[$i]; ?></legend>
            <?php foreach ($answers[$i] as $a => $answer) : ?>
                <label><input type="radio" name="<?= $i; ?>"
                              value="<?= $answer['a']; ?>"> <?= $answer['a']; ?>
                </label>
            <?php endforeach; ?>
        </fieldset>
    <?php endfor; ?><br>
    <input type="text" name="user" placeholder="Введите ваше имя"><br><br>
    <input type="hidden" name="title" value=<?= $testName ?>>
    <input type="hidden" name="result" value=<?= $result ?>>
    <input type="hidden" name="sum" value=<?= count($questions) ?>>
    <input type="submit" value="Отправить">
</form>
<br>
<?php echo $info; ?>
</body>
</html>