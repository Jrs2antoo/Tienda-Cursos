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
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Curso($row), $rows);
    }

    public function exists(int $userId, int $courseId): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM purchases WHERE user_id = :user_id AND course_id = :course_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        return (bool) $stmt->fetch();
    }

    /**
     * Registra la compra de un curso por un usuario.
     * Usa INSERT IGNORE, por lo que no falla si la relación ya existe.
     *
     * @param int $userId   ID del usuario comprador
     * @param int $courseId ID del curso adquirido
     */
    public function add(int $userId, int $courseId): bool
    {
        $stmt = $this->db->prepare("INSERT IGNORE INTO purchases (user_id, course_id) VALUES (:user_id, :course_id)");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function remove(int $userId, int $courseId): void
    {
        $stmt = $this->db->prepare("DELETE FROM purchases WHERE user_id = :user_id AND course_id = :course_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
    }

}
