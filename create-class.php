<?php

use Alura\Pdo\Database\Connection;
use Alura\Pdo\Domain\Model\Student;

require __DIR__ . "/vendor/autoload.php";

$connection = Connection::getInstance();
$studentRepository = new Alura\Pdo\Database\Repository\StudentRepository($connection);


$connection->beginTransaction();

try {
    $danilo = new Student(null, "Danilera Carlos Marques", new DateTime("1991-11-07"));
    $studentRepository->save($danilo);

    $samara = new Student(null, "Samara Reis", new DateTime("1995-02-02"));
    $studentRepository->save($samara);

    $connection->commit();
} catch (Exception $e) {
    $connection->rollBack();
}