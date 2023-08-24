<?php

use Alura\Pdo\Database\Connection;
use Alura\Pdo\Database\Repository\StudentRepository;

require_once __DIR__ . "/vendor/autoload.php";

$connection = Connection::getInstance();
$repository = new StudentRepository($connection);

$studentList = $repository->getWithPhones();

foreach ($studentList as $student) {
    foreach ($student->getPhones() as $phone) {
        echo "{$phone->getFormattedPhone()} <br/>";
    }
}