<?php
require_once 'functions.php';
session_start();

const HOST = '127.0.0.1:3306';
const DB = 'global';
const USER = 'mysql';
const PASS = 'mysql';
const TASK_STATE_COMPLETE = 2;
const TASK_STATE_IN_PROGRESS = 1;

ini_set("display_errors", "1"); // Показ ошибок
ini_set("display_startup_errors", "1");
ini_set('error_reporting', E_ALL);

spl_autoload_register(function($name) {
    $file = dirname(__DIR__) . '/assets/' . $name . '.class.php';
    if (!file_exists($file)) {
        throw new Exception('Autoload class: File ' . $file . ' not found');
    }
    require $file;
});

$user = new User;