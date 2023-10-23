<?php

namespace App\Services\Database;

use PDO;

class Mysql extends Database
{
    protected PDO $db;

    public function getConnection(): PDO
    {
        return $this->db;
    }

    protected function prepareConnection(): void
    {
        $servername = $_ENV['DB_HOST'];
        $database = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->db = $connection;
    }
}