<?php
require_once 'functions.php';

if (isPOST()) {
    if (login(getParam('login'), getParam('password'))) {
        location('list');
    }
    if (!empty($_POST['name'])) {
        $_SESSION = $_POST;
        location('list');
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Задание к занятию «Куки, сессии и авторизация»</title>
    <meta name="description" content="Нетология. Курс PHP/SQL. Урок 2.4">
</head>
<body>
<form method="POST">
    <h3>Войти как зарегистрированный пользователь:</h3>
    <label>Логин: <input name="login" id="login"></label>
    <label>Пароль: <input name="password" id="password"></label>
    <h3>или войти как гость:</h3>
    <label>Имя: <input name="name" id="name"></label><br><br>
    <button type="submit"> Вход</button>
</form>
</body>
</html>