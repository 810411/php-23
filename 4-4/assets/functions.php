<?php

function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function getParam($name)
{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
}

function redirect($action, $parameters)
{
    $parameters = isset($parameters) ? $parameters : '';
    header('Location: ' . $action . '.php' . $parameters);
    die;
}