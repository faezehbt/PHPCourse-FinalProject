<?php

require 'config.php';


try{
    // echo "connecting to db ...<br>";
    $conn = new PDO("mysql:host=". DB_HOST .";dbname=". DB_NAME, DB_USER,DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    // echo "connected";

} catch (PDOException $e) {
    die("ارتباط با دیتابیس برقرار نشد");
}