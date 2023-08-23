<?php

use Alura\Pdo\Domain\Model\Student;

require_once __DIR__ . "/vendor/autoload.php";

$connection = new PDO('mysql:host=db;dbname=fsphp', "root", "a654321");
$student = new Student(
    null,
    "Danilo Marques",
    new DateTimeImmutable('1991-07-11')
);

$insert = "INSERT INTO students (name, birth_date) VALUES ('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}')";

var_dump($connection->exec($insert));
