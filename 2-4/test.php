<?php
require_once 'functions.php';
if (!isAuthorized()) {
    location('index');
}
$result = 0;
$info = $_SESSION['name'] . ', выберите ответы';

if (array_key_exists('test', $_GET)) {
    $test = json_decode(file_get_contents($_GET['test']), true);
    $testName = pathinfo($_GET['test'])['filename'];
}

if (!isset($test[0]['q'])) {
    http_response_code(404);
    echo '<h3>404. Not Found </h3>';
    echo '<h3>Запрашиваемая страница не найдена </h3><br>';
    echo '<br><a href="list.php">Список загруженных тестов</a>';
    exit(0);
}

foreach ($test as $key => $value) {
    $questions[] = $value['q'];
    $answers[] = $value['ans'];
}

if (!empty($_POST)) {
    $userAnswers = $_POST;
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
        $texts[] = $_SESSION['name'];
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
        session_destroy();
        exit(0);

    } else if (!empty($_POST)) {
        $info = $_SESSION['name'] . ', вы ответили неправильно';
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
<h3><?= $testName ?></h3>
<p><b><?php echo $info; ?></b></p>
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
    <input type="submit" value="Отправить">
</form>
<br>
<a href="list.php">
    <button>Список тестов</button>
</a>
</body>
</html>