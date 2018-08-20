<?php
    $name = "Григорий";
    $age = 36;
    $email = "810411@mail.ru";
    $city = "Уфа";
    $about = "Живу как завещал В. И. Ленин";
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <style>
            body {
                font-family: sans-serif;
            }

            dl {
                display: table-row;
            }

            dt, dd {
                display: table-cell;
                padding: 5px 10px;
            }
        </style>
        <title><?= "$name - "?> Студент университета «Нетология»</title>
        <meta name="description" content="Нетология. Урок 1.1">
    </head>
    <body>
        <h1>Страница студента <?= $name?></h1>
            <dl>
                <dt>Имя</dt>
                <dd><?= $name ?></dd>
            </dl>
        <dl>
            <dt>Возраст</dt>
            <dd><?= $age ?></dd>
        </dl>
        <dl>
            <dt>Адрес электронной почты</dt>
            <dd><a href="mailto:<?= $email ?>"><?= $email ?></a></dd>
        </dl>
        <dl>
            <dt>Город</dt>
            <dd><?= $city ?></dd>
        </dl>
        <dl>
            <dt>О себе</dt>
            <dd><?= $about ?></dd>
        </dl>
    </body>
</html>
<!-- Домашнее задание 1.1 -->