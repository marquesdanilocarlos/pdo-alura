<?php

use Alura\Pdo\Database\Connection;
use Alura\Pdo\Domain\Model\Student;

require_once __DIR__ . "/vendor/autoload.php";

$connection = Connection::getInstance();
$student = new Student(
    null,
    "Danilo Carlos",
    new DateTimeImmutable('1997-07-11')
);

$insert = "INSERT INTO students (name, birth_date) VALUES (:name, :birthDate)";
$stmt = $connection->prepare($insert);
$stmt->bindValue(':name', $student->getName(), PDO::PARAM_STR);
$stmt->bindValue(':birthDate', $student->getBirthDate()->format('Y-m-d'), PDO::PARAM_STR);

if($stmt->execute()) {
    echo "Aluno inserido!";
}
