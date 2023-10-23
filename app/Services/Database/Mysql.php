<?php

namespace App\Services\Database;

use App\Entities\Entity;
use PDO;

class Mysql extends DatabaseConnection
{
    protected PDO $db;

    public function prepareConnection(): void
    {
        $servername = $_ENV['DB_HOST'];
        $database = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $connection = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->db = $connection;
    }

    public function all(Entity $entity): array
    {
        return $this->db->query('SELECT * FROM ' . $entity->getTableName())->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(Entity $entity): ?array
    {
        $parameters = implode(',', $entity->getFields());
        $placeholders = implode(',', str_split(str_repeat('?', count($entity->getFields())), 1));

        $sql = 'INSERT INTO ' . $entity->getTableName() . ' (' . $parameters . ') VALUES (' . $placeholders . ');';

        $stmt = $this->db->prepare($sql);
        $a = $stmt->execute($entity->toArray());

        return $this->find($entity->getId());
    }

    public function find(Entity $entity, int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $entity->getTableName() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        return $result;
    }

    public function delete(Entity $entity, int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM ' . $entity->getTableName() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}