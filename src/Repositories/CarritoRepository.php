<?php
namespace Jrs2a\TiendaCursos\Repositories;

use Jrs2a\TiendaCursos\Core\Database;
use Jrs2a\TiendaCursos\Models\Curso;
use PDO;

class CarritoRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Devuelve los cursos que tiene el usuario en el carrito.
     * Hace JOIN con courses para devolver objetos Curso completos.
     *
     * @return Curso[]
     */
    public function findByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT c.* FROM carrito ca
            JOIN courses c ON ca.course_id = c.id
            WHERE ca.user_id = :user_id
        ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Curso($row), $rows);}

    public function findCourseIdsByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT course_id FROM carrito WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return array_column(
            $stmt->fetchAll(PDO::FETCH_ASSOC),
            'course_id'
        );
    }

    public function add(int $userId, int $courseId): void
    {
        $stmt = $this->db->prepare("INSERT IGNORE INTO carrito (user_id, course_id) VALUES (:user_id, :course_id)");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function remove(int $userId, int $courseId): void
    {
        $stmt = $this->db->prepare("DELETE FROM carrito WHERE user_id = :user_id AND course_id = :course_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function clearByUser(int $userId): void
    {
        $stmt = $this->db->prepare("DELETE FROM carrito WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
