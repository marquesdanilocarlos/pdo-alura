<?php

require_once __DIR__ . "/vendor/autoload.php";

$connection = new PDO('mysql:host=db;dbname=fsphp', "root", "a654321");

$stmt = $connection->prepare("DELETE FROM students WHERE id = :id");
$stmt->bindValue(":id", 17, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "Aluno excluído!";
}