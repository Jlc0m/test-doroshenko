<?php

namespace App\Models;

class File
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO(
            "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",$_ENV['DB_USER'],$_ENV['DB_PASS']
        );
    }

    public function getTotalCount(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM files");
        return $stmt->fetchColumn();
    }

    public function getFiles(int $page, int $itemsPerPage, string $sortBy = 'created_at', string $sortOrder = 'DESC'): array
    {
        $offset = ($page - 1) * $itemsPerPage;
        $stmt = $this->db->prepare("SELECT * FROM files ORDER BY {$sortBy} {$sortOrder} LIMIT :offset, :limit");
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':limit', $itemsPerPage, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addFile(string $name, string $path, string $type): bool
    {
        $stmt = $this->db->prepare("INSERT INTO files (name, path, type, created_at) VALUES (:name, :path, :type, NOW())");
        return $stmt->execute([
            ':name' => $name,
            ':path' => $path,
            ':type' => $type
        ]);
    }

    public function deleteFile(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM files WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function updateFile(int $id, string $name, string $path, string $type): bool
    {
        $stmt = $this->db->prepare("UPDATE files SET name = :name, path = :path, type = :type WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':path' => $path,
            ':type' => $type
        ]);
    }

    public function getFileById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM files WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : null;
    }
}