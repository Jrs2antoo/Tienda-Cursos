<?php
namespace Jrs2a\TiendaCursos\Requests;

class RegisterRequest
{
    public string $fullName;
    public string $email;
    public string $password;
    public array $errors = [];
    /**
     * Valida los datos del formulario de registro de un nuevo usuario.
     *
     * @param array<string, mixed> $data  Datos del formulario, normalmente $_POST
     *
     * Campos esperados:
     * - full_name  string  Nombre completo del usuario
     * - email      string  Email con formato válido
     * - password   string  Mínimo 8 caracteres
     * - password2  string  Debe coincidir con password
     */
    public function __construct(array $post)
    {
        $this->fullName = htmlspecialchars(trim($post['full_name'] ?? ''), ENT_QUOTES, 'UTF-8');
        $this->email    = trim(filter_var($post['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $this->password = $post['password'] ?? '';
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

        if (empty($this->password)) {
            $this->errors[] = 'La contraseña es obligatoria.';
        } elseif (strlen($this->password) < 8) {
            $this->errors[] = 'La contraseña debe tener al menos 8 caracteres.';
        }

        return empty($this->errors);
    }
}
