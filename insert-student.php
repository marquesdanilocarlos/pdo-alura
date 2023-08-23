<?php

use Alura\Pdo\Domain\Model\Student;

require_once __DIR__ . "/vendor/autoload.php";

$connection = new PDO('mysql:host=db;dbname=fsphp', "root", "a654321");
$student = new Student(
    null,
    "Danilo Carlos",
    new DateTimeImmutable('1997-07-11')
);

$insert = "INSERT INTO students (name, birth_date) VALUES (:name, :birthDate)";
$stmt = $connection->prepare($insert);
$stmt->bindValue(':name', $student->name(), PDO::PARAM_STR);
$stmt->bindValue(':birthDate', $student->birthDate()->format('Y-m-d'), PDO::PARAM_STR);

if($stmt->execute()) {
    echo "Aluno inserido!";
}
