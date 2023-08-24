<?php

namespace Alura\Pdo\Database;

use PDO;

class Connection
{
    private const DB_HOST = "db";
    private const DB_NAME = "fsphp";
    private const DB_USER = "root";
    private const DB_PASS = "a654321";

    private static PDO $instance;
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    public static function getInstance(): PDO
    {
        if (empty(self::$instance)) {
            self::$instance = new PDO(
                "mysql:host=" . self::DB_HOST . ";dbname=fsphp",
                self::DB_USER,
                self::DB_PASS,
                self::OPTIONS
            );
        }

        return self::$instance;
    }
}