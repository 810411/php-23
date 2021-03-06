<?php
$info = '';

$uploadsDir = __DIR__ . '/uploads';
if (!file_exists($uploadsDir)) mkdir($uploadsDir);

if ($_FILES) {
    $name = basename($_FILES['userfile']['name']);
    $tmpName = $_FILES['userfile']['tmp_name'];
    $pathInfo = pathinfo($name);

    if ($_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
        json_decode(file_get_contents($tmpName));

        if (json_last_error() == 0) {
            if (move_uploaded_file($tmpName, "$uploadsDir/$name")) {
                header("Location: list.php");
                exit(0);
            }
        } else {
            $info = "Ошибка загрузки файла";
        }
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
    <li><a href="list.php">Список загруженных тестов</a></li>
</ul>
<h3>Загрузка тестов</h3>
<form enctype="multipart/form-data" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000"/>
    Выберите файл с тестами в формате JSON: <br>
    <input name="userfile" type="file"/><br>
    <input type="submit" value="Загрузить"/><br>
    <?php echo $info ?>
</form>
</body>
</html>