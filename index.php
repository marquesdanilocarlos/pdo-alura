<?php

require __DIR__ . "/vendor/autoload.php";

use Alura\Pdo\Database\Connection;
use Alura\Pdo\Database\Repository\StudentRepository;
use Alura\Pdo\Domain\Model\Student;

$repository = new StudentRepository(Connection::getInstance());

$student = $repository->getById(6);
$students = $repository->getAll();
$studentsBirthday = $repository->getByBirthday(new DateTime("1991-11-07"));

if ($student) {
    $repository->remove($student);
    echo "Aluno removido!";
}

//$newStudent = $repository->getById(22);
$newStudent = new Student(null, "Cleitinho Godofá", new DateTime("1966-08-12"));
//$newStudent->setName("Cleiton Godofa");
if ($repository->save($newStudent)) {
    echo "Aluno salvo!";
}

var_dump($newStudent);

