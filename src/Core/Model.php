<?php

declare(strict_types=1);

namespace App\Core;

abstract class Model
{
    protected Database $db;
    protected string $table;

    public function __construct() {
        $this->db = new Database();
    }

    public function findOne(array $conditions): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE ";
        $whereConditions = [];
        $params = [];

        foreach ($conditions as $key => $value) {
            $whereConditions[] = "$key = ?";
            $params[] = $value;
        }

        $sql .= implode(' AND ', $whereConditions) . " LIMIT 1";

        $result = $this->db->query($sql, $params);
        return $result->fetch() ?: null;

    }

    public function findAll(array $conditions = []): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if (!empty($conditions)) {
            $whereConditions = [];
            $sql .= " WHERE ";

            foreach ($conditions as $key => $value) {
                $whereConditions[] = "$key = ?";
                $params[] = $value;
            }

            $sql .= implode(' AND ', $whereConditions);
        }

        $result = $this->db->query($sql, $params);
        return $result->fetchAll();
    }

    public function create(array $data): bool
    {
        $keys = array_keys($data);
        $values = array_values($data);
        $placeholders = str_repeat('?,', count($data) - 1) . '?';

        $sql = "INSERT INTO {$this->table} (" . implode(',', $keys) . ") VALUES ($placeholders)";

        return $this->db->query($sql, $values)->rowCount() > 0;
    }

    public function update(int $id, array $data): bool
    {
        $setClauses = [];
        $params = [];

        foreach ($data as $key => $value) {
            $setClauses[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(',', $setClauses) . " WHERE id = ?";

        return $this->db->query($sql, $params)->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->query($sql, [$id])->rowCount() > 0;
    }
}