<?php

use Alura\Pdo\Database\Connection;

require_once __DIR__ . "/vendor/autoload.php";

$connection = Connection::getInstance();

$stmt = $connection->prepare("DELETE FROM students WHERE id = :id");
$stmt->bindValue(":id", 17, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "Aluno excluído!";
}