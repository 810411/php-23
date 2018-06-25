<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
mb_internal_encoding('UTF-8'); // Кодировка по умолчанию
ini_set('display_errors', 1);

$config = include 'assets/config.php';

/**
 * Подключение к базе данных
 */
include 'assets/DataBase.php';

$db = DataBase::connect(
    $config['mysql']['host'],
    $config['mysql']['dbname'],
    $config['mysql']['user'],
    $config['mysql']['pass']
);

include 'router/router.php';

//include 'view/user/register.php';