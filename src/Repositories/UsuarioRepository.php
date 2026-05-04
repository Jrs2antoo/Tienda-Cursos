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
        return array_map(
            fn($row) => new Usuario($row),
            $this->db->query("SELECT id, full_name, email, role, created_at FROM users ORDER BY id")
                ->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findById(int $id): ?Usuario
    {
        $stmt = $this->db->prepare("SELECT id, full_name, email, role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    }

    public function findByEmail(string $email): ?Usuario
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    }

    public function findByToken(string $token): ?Usuario
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE token = ?");
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Usuario($row) : null;
    }

    public function create(string $fullName, string $email, string $passwordHash, string $token, int $tokenExp): bool
    {
        return $this->db->prepare("INSERT INTO users (full_name, email, password, token, token_exp, confirmado) VALUES (?, ?, ?, ?, ?, 0)")
            ->execute([$fullName, $email, $passwordHash, $token, $tokenExp]);
    }

    public function update(int $id, string $fullName, string $email, string $role, ?string $passwordHash = null): bool
    {
        $sql    = "UPDATE users SET full_name = :name, email = :email, role = :role";
        $params = ['name' => $fullName, 'email' => $email, 'role' => $role, 'id' => $id];

        if ($passwordHash !== null) {
            $sql           .= ", password = :pass";
            $params['pass'] = $passwordHash;
        }

        $sql .= " WHERE id = :id";
        return $this->db->prepare($sql)->execute($params);
    }

    public function confirmar(int $id): bool
    {
        return $this->db->prepare("UPDATE users SET confirmado = 1, token = '', token_exp = 0 WHERE id = ?")
            ->execute([$id]);
    }

    public function delete(int $id): void
    {
        $this->db->prepare("DELETE FROM purchases WHERE user_id = ?")->execute([$id]);
        $this->db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
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
        return $this->db->query("
            SELECT u.id, u.full_name, u.email,
                   GROUP_CONCAT(c.id ORDER BY c.title SEPARATOR ',')    AS curso_ids,
                   GROUP_CONCAT(c.title ORDER BY c.title SEPARATOR '|') AS curso_titulos
            FROM users u
            LEFT JOIN purchases p ON u.id = p.user_id
            LEFT JOIN courses c   ON p.course_id = c.id
            GROUP BY u.id
            ORDER BY u.full_name
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}