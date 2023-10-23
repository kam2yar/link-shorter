<?php

namespace Database\Connections;

use App\DTO\ResultCollection;
use App\Entities\Entity;
use PDO;

class Mysql extends DatabaseConnection
{
    protected PDO $db;

    public function prepareConnection(): void
    {
        $servername = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $connection = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->db = $connection;
    }

    public function all(Entity $entity): ResultCollection
    {
        $result = new ResultCollection();

        $data = $this->db->query('SELECT * FROM ' . $entity->getTableName())->fetchAll();

        foreach ($data as $item) {
            $result->add($entity->mapToObject($item));
        }

        return $result;
    }

    public function save(Entity $entity): Entity
    {
        $sql = 'INSERT INTO ' . $entity->getTableName() . ' (id, title, body) VALUES (:id, :title, :body);';

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $entity->getId(),
            'title' => $entity->getTitle(),
            'body' => $entity->getBody()
        ]);

        return $this->find($entity->getId());
    }

    public function find(Entity $entity, int $id): ?Entity
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $entity->getTableName() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();
        if (!$result) {
            return null;
        }

        return $entity->mapToObject($result);
    }

    public function delete(Entity $entity, int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM ' . $entity->getTableName() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}