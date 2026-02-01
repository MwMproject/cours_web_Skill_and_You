<?php
$pdo = new PDO("mysql:host=localhost;dbname=php_intermediaire_1;charset=utf8","root","");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
?>