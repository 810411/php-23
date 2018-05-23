<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

function login($login, $password)
{
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['login'] == $login && $user['password'] == $password) {
            unset($user['password']);
            $_SESSION = $user;
            return true;
        }
    }
    return false;
}

function getLoggedUserData()
{
    if (empty($_SESSION)) {
        return null;
    }
    return $_SESSION;
}

function isAuthorized()
{
    return getLoggedUserData() !== null;
}

function getUsers()
{
    $path = __DIR__ . '/data/login.json';
    $fileData = file_get_contents($path);
    $data = json_decode($fileData, true);
    if (!$data) {
        return [];
    }
    return $data;
}

function isPOST()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function getParam($name)
{
    return filter_input(INPUT_POST, $name);
}

function location($path)
{
    header("Location: $path.php");
    die;
}