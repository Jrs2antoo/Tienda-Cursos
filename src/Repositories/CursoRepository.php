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
        $stmt = $this->db->prepare("SELECT * FROM courses ORDER BY id DESC");
        $stmt->execute();

        return array_map(
            fn($row) => new Curso($row),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
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
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Curso($row) : null;
    }

    public function create(string $title, string $description, float $price, int $stock, string $imageUrl): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO courses (title, description, price, stock, imagen)
            VALUES (:title, :description, :price, :stock, :image)
        ");
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindValue(':image', $imageUrl, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update(int $id, string $title, string $description, float $price, int $stock, string $imageUrl): bool
    {
        $stmt = $this->db->prepare("
            UPDATE courses
            SET title = :title, description = :description, price = :price, stock = :stock, imagen = :image
            WHERE id = :id
        ");
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindValue(':image', $imageUrl, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM purchases WHERE course_id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function hasStock(int $id): bool
    {
        $stmt = $this->db->prepare("SELECT stock FROM courses WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return (int)$stmt->fetchColumn() > 0;
    }

    public function decreaseStock(int $id): bool
    {
        $stmt = $this->db->prepare("
            UPDATE courses
            SET stock = stock - 1
            WHERE id = :id AND stock > 0
        ");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function increaseStock(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE courses SET stock = stock + 1 WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
