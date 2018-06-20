<?php

class ConnectDB
{
    protected function getConnection()
    {
        $host = HOST;
        $db = DB;
        $connect = new PDO(
            "mysql:host=$host;dbname=$db;charset=utf8",
            USER,
            PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        ) or die('Connect to MySQL server failed');
        return $connect;
    }
}