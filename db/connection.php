<?php
function getPDO()
{
    $host = "localhost";
    $dbName = "lesson_management";
    $username = "root";
    $password = "";
    $charset = "utf8mb4";

    $dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";

    try {
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);

        return $pdo;
    } catch (PDOException $e) {
        return [
            "success" => false,
            "message" => "Database connection failed",
            "error" => $e->getMessage()
        ];
    }
}
