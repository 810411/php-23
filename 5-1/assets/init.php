<?php

require "./vendor/autoload.php";

session_start();

ini_set("display_errors", "1"); // Показ ошибок
ini_set("display_startup_errors", "1");
ini_set('error_reporting', E_ALL);

spl_autoload_register(function ($name) {
    $file = dirname(__DIR__) . '/assets/' . $name . '.class.php';
    if (!file_exists($file)) {
        throw new Exception('Autoload class: File ' . $file . ' not found');
    }
    require $file;
});

function getParam($name)
{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
}