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

    /** @return Curso[] Solo cursos activos (para la tienda pública) */
    public function findAll(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE activo = 1 ORDER BY id DESC");
        $stmt->execute();

        return array_map(
            fn($row) => new Curso($row),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /** @return Curso[] Todos los cursos incluyendo inactivos (para el panel admin) */
    public function findAllAdmin(): array
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
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE activo = 1 LIMIT ?");
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

    /**
     * Borrado lógico: marca el curso como inactivo.
     * No elimina compras ni datos históricos.
     */
    public function desactivar(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE courses SET activo = 0 WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /** Reactiva un curso previamente desactivado */
    public function activar(int $id): void
    {
        $stmt = $this->db->prepare("UPDATE courses SET activo = 1 WHERE id = :id");
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