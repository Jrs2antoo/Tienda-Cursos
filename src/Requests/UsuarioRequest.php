<?php
namespace Jrs2a\TiendaCursos\Requests;

class UsuarioRequest
{
    public int $id;
    public string $fullName;
    public string $email;
    public string $role;
    public ?string $password;
    public array $errors = [];

    public function __construct(array $post)
    {
        $this->id       = (int)($post['id'] ?? 0);
        $this->fullName = htmlspecialchars(trim($post['full_name'] ?? ''), ENT_QUOTES, 'UTF-8');
        $this->email    = trim(filter_var($post['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $this->role     = in_array($post['role'] ?? '', ['user', 'admin']) ? $post['role'] : 'user';
        $this->password = !empty($post['password']) ? $post['password'] : null;
    }

    public function isValid(): bool
    {
        if (empty($this->fullName)) {
            $this->errors[] = 'El nombre completo es obligatorio.';
        }

        if (empty($this->email)) {
            $this->errors[] = 'El email es obligatorio.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'El email no tiene un formato válido.';
        }

        if ($this->password !== null && strlen($this->password) < 8) {
            $this->errors[] = 'La contraseña debe tener al menos 8 caracteres.';
        }

        return empty($this->errors);
    }
}
