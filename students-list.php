<?php

use Alura\Pdo\Database\Connection;

require_once __DIR__ . "/vendor/autoload.php";

$connection = Connection::getInstance();

$stmt = $connection->query("SELECT * FROM students WHERE id = 18");
//$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$list = $stmt->fetchAll(PDO::FETCH_CLASS, stdClass::class);
//$list = $stmt->fetchAll(PDO::FETCH_OBJ);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($student);
