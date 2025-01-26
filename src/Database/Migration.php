<?php

declare(strict_types=1);

namespace App\Database;

use App\Core\Database;


class Migration
{
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function applyMigrations(): void {
        $this->createMigrationsTable();
        $files = $this->getMigrationFiles();

        foreach ($files as $file) {
            $migration = file_get_contents($file);
            $this->db->query($migration);

            $filename = pathinfo($file, PATHINFO_FILENAME);
            $this->logMigration($filename);
        }
    }

    private function createMigrationsTable(): void {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    private function getMigrationFiles(): array {
        $files = glob(__DIR__ . '/migrations/tables/*.sql');
        var_dump($files);  // Add this to see what files were found
        return $files ?: [];
    }

    private function logMigration(string $filename): void {
        $this->db->query(
            "INSERT INTO migrations (migration) VALUES (?)",
            [$filename]
        );
    }
}