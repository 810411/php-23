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
    <?php
    $info = '';

    if ($_FILES) {
        $name = $_FILES['userfile']['name'];
        $path_info = pathinfo($name);

        if ($_FILES['userfile']['error'] == UPLOAD_ERR_OK && $_FILES['userfile']['type'] == 'text/plain' && $path_info['extension'] === 'json') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], $name);
            $info = "Файл загружен";
        } else {
            $info = "Ошибка загрузки файла";
        }
    }
    ?>
    <h3>Загрузка тестов</h3>
    <form enctype="multipart/form-data" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        Выберите файл с тестами в формате JSON: <br>
        <input name="userfile" type="file" /><br>
        <input type="submit" value="Загрузить" /><br>
        <?php echo $info ?>
    </form>
    </body>
</html>