<?php

require_once __DIR__ . "/DatabasePDO.php";

class Repository {
    protected PDO $db;
    protected string $table;
    protected string $entityClass;

    public function __construct(
        string $table,
        string $entityClass,
        PDO $db = null
    ) {
        $this -> db = $db ?? DatabasePDO::getConnection();
        $this -> table = $table;
        $this -> entityClass = $entityClass;
    }

    public function findAll(): array {
        $stmt = $this -> db -> query("SELECT * FROM {$this -> table}");
        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToEntity'], $rows);
    }

    public function findById(int $id): ?object {
        $stmt = $this -> db -> prepare("SELECT * FROM {$this -> table} WHERE id = :id");
        $stmt -> execute(['id' => $id]);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $row ? $this -> mapToEntity($row) : null;
    }

    public function create(array $data): int {
        $fields = array_keys($data);
        $placeholders = array_map(fn($field) => ":$field", $fields);
        $sql = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $fields = array_keys($data);
        $set = implode(', ', array_map(fn($f) => "$f = :$f", $fields));
        $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    protected function mapToEntity(array $row): object {
        $entity = new $this -> entityClass();
        foreach ($row as $key => $value) {
            if ( property_exists($entity, $key) ) {
                $entity -> $key = $value;
            }
        }
        return $entity;
    }
}
