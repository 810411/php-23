<?php
require_once 'functions.php';

if ($_FILES['json']['error'] == UPLOAD_ERR_OK) {
    json_decode(file_get_contents($_FILES['json']['tmp_name']));

    if (json_last_error() == 0) {
        if (move_uploaded_file($_FILES['json']['tmp_name'], 'uploads/' . $_FILES['json']['name'])) {
            location('list');
        }
    } else {
        echo '<h3>Ошибка загрузки файла</h3>';
    }
}
if (empty($_FILES['json']['tmp_name'])) {
    echo '<h3>Вы не выбрали файл для загрузки!</h3>';
    echo '<br><a href="list.php">Список загруженных тестов</a>';
}