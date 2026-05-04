<?php
namespace Jrs2a\TiendaCursos\Repositories;

use Jrs2a\TiendaCursos\Core\Database;
use PDO;
use Jrs2a\TiendaCursos\Models\Curso;

class CompraRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function findByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT c.*
            FROM purchases p
            JOIN courses c ON p.course_id = c.id
            WHERE p.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Curso($row), $rows);
    }

    public function exists(int $userId, int $courseId): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM purchases WHERE user_id = ? AND course_id = ?");
        $stmt->execute([$userId, $courseId]);
        return (bool) $stmt->fetch();
    }

    public function add(int $userId, int $courseId): void
    {
        $this->db->prepare("INSERT IGNORE INTO purchases (user_id, course_id) VALUES (?, ?)")
            ->execute([$userId, $courseId]);
    }

    public function remove(int $userId, int $courseId): void
    {
        $this->db->prepare("DELETE FROM purchases WHERE user_id = ? AND course_id = ?")
            ->execute([$userId, $courseId]);
    }
}
