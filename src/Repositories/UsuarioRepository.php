<?php
namespace Jrs2a\TiendaCursos\Repositories;

use Jrs2a\TiendaCursos\Core\Database;
use Jrs2a\TiendaCursos\Models\Usuario;
use PDO;

class UsuarioRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /** @return Usuario[] */
    public function findAll(): array
    {
        $stmt = $this->db->prepare("SELECT id, full_name, email, role, created_at FROM users ORDER BY id");
        $stmt->execute();

        return array_map(
            fn($row) => new Usuario($row),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findById(int $id): ?Usuario
    {
        $stmt = $this->db->prepare("SELECT id, full_name, email, role FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    }

    public function findByEmail(string $email): ?Usuario
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    }

    public function findByToken(string $token): ?Usuario
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE token = :token");
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    }

    public function create(string $fullName, string $email, string $passwordHash, string $token, int $tokenExp): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (full_name, email, password, token, token_exp, confirmado)
            VALUES (:full_name, :email, :password, :token, :token_exp, 0)
        ");
        $stmt->bindValue(':full_name', $fullName, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->bindValue(':token_exp', $tokenExp, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update(int $id, string $fullName, string $email, string $role, ?string $passwordHash = null): bool
    {
        $sql    = "UPDATE users SET full_name = :name, email = :email, role = :role";

        if ($passwordHash !== null) {
            $sql .= ", password = :pass";
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $fullName, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($passwordHash !== null) {
            $stmt->bindValue(':pass', $passwordHash, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public function confirmar(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET confirmado = 1, token = '', token_exp = 0 WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM purchases WHERE user_id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Devuelve todos los usuarios con sus cursos agregados en una sola consulta.
     * Útil para el panel de administración de compras.
     *
     * @return array<int, array{
     *     id: int,
     *     full_name: string,
     *     email: string,
     *     curso_ids: string|null,      // IDs separados por coma, ej: "1,3,5"
     *     curso_titulos: string|null   // Títulos separados por "|", ej: "PHP|Laravel|MySQL"
     * }>
     */
    public function findAllConCursos(): array
    {
        // Devuelve array asociativo porque mezcla datos de varias tablas
        $stmt = $this->db->prepare("
            SELECT u.id, u.full_name, u.email,
                   GROUP_CONCAT(c.id ORDER BY c.title SEPARATOR ',')    AS curso_ids,
                   GROUP_CONCAT(c.title ORDER BY c.title SEPARATOR '|') AS curso_titulos
            FROM users u
            LEFT JOIN purchases p ON u.id = p.user_id
            LEFT JOIN courses c   ON p.course_id = c.id
            GROUP BY u.id
            ORDER BY u.full_name
        ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
