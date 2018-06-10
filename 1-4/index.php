<?php
$city = 'Ufa,RU';
$mode = 'json';
$units = 'metric';
$lang = 'ru';
$appid = 'e3fb0b77258f9a1408fdc64e00ae3f93';

$url = "http://api.openweathermap.org/data/2.5/weather?q=$city,RU&mode=$mode&units=$units&lang=$lang&appid=$appid";

$weather = @file_get_contents($url);
$weatherArray = json_decode($weather, true);

if ($weatherArray !== 0) {
    $temperature = (!empty($weatherArray['main']['temp'])) ? $weatherArray['main']['temp'] . '°' : 'нет данных';
    $description = (!empty($weatherArray['weather']['0']['description'])) ?
        $weatherArray['weather']['0']['description'] : 'нет данных';
    $pressure = (!empty($weatherArray['main']['pressure'])) ? round($weatherArray['main']['pressure'] * 0.75)
        . ' мм рт. ст' : 'нет данных';
    $humidity = (!empty($weatherArray['main']['humidity'])) ? $weatherArray['main']['humidity'] . ' %' : 'нет данных';
    $wind = (!empty($weatherArray['wind']['speed'])) ? $weatherArray['wind']['speed'] . ' м/с' : 'нет данных';
    $date = (!empty($weatherArray['dt'])) ? date('d.m.Y  H+6:i', $weatherArray['dt']) : 'нет данных';
    $icon = (!empty($weatherArray['weather']['0']['icon'])) ? 'http://openweathermap.org/img/w/' .
        $weatherArray['weather']['0']['icon'] . '.png' : 'нет данных';
} else {
    exit('Ошибка декодирования json');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Домашнее задание к лекции 1.4 «Стандартные функции»</title>
    <meta name="description" content="Нетология. Задание 1.4">
</head>
<body>
<table>
    <tr>
        <td colspan="2"><h2>Погода в городе Уфа</h2></td>
    </tr>
    <tr>
        <td><img src=<?= $icon ?> alt=""></td>
        <td><?= $description ?></td>
    </tr>
    <tr>
        <td>Температура:</td>
        <td><?= $temperature ?></td>
    </tr>
    <tr>
        <td>Давление:</td>
        <td><?= $pressure ?></td>
    </tr>
    <tr>
        <td>Влажность:</td>
        <td><?= $humidity ?></td>
    </tr>
    <tr>
        <td>Скорость ветра:</td>
        <td><?= $wind ?></td>
    </tr>
    <tr>
        <td>Данные от:</td>
        <td><?= $date ?></td>
    </tr>
</table>
</body>
</html>