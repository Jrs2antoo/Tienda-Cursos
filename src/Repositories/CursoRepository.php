<?php
namespace Jrs2a\TiendaCursos\Repositories;

use Jrs2a\TiendaCursos\Core\Database;
use Jrs2a\TiendaCursos\Models\Curso;
use PDO;

class CursoRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /** @return Curso[] */
    public function findAll(): array
    {
        return array_map(
            fn($row) => new Curso($row),
            $this->db->query("SELECT * FROM courses ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /** @return Curso[] */
    public function findAllLimit(int $limit): array
    {
        $stmt = $this->db->prepare("SELECT * FROM courses LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return array_map(fn($row) => new Curso($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById(int $id): ?Curso
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Curso($row) : null;
    }

    public function create(string $title, string $description, float $price, string $imageUrl): bool
    {
        return $this->db->prepare("INSERT INTO courses (title, description, price, image_url) VALUES (:t,:d,:p,:i)")
            ->execute(['t' => $title, 'd' => $description, 'p' => $price, 'i' => $imageUrl]);
    }

    public function update(int $id, string $title, string $description, float $price, string $imageUrl): bool
    {
        return $this->db->prepare("UPDATE courses SET title=:t, description=:d, price=:p, image_url=:i WHERE id=:id")
            ->execute(['t' => $title, 'd' => $description, 'p' => $price, 'i' => $imageUrl, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $this->db->prepare("DELETE FROM purchases WHERE course_id = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM courses WHERE id = ?")->execute([$id]);
    }
}