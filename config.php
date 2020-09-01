<?php
session_start();
$base = 'http://localhost/projetos/dvs-oo';

$db_name = 'devsbook';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '123';

$maxHeight = 800;
$maxWidth = 800;

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);