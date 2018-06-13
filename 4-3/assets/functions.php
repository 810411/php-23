<?php

function getConnection()
{
    $host = HOST;
    $db = DB;
    $connect = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        USER,
        PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    ) or die('Cannot connect to MySQL server :(');
    return $connect;
}

function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function getParam($name)
{
    if(isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    } else {
        return null;
    }
}

function redirect($action)
{
    header('Location: ' . $action . '.php');
    die;
}