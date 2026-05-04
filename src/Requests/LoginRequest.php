<?php
namespace Jrs2a\TiendaCursos\Requests;

class LoginRequest
{
    public string $email;
    public string $password;
    public array $errors = [];

    public function __construct(array $post)
    {
        $this->email    = trim(filter_var($post['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $this->password = $post['password'] ?? '';
    }

    public function isValid(): bool
    {
        if (empty($this->email)) {
            $this->errors[] = 'El email es obligatorio.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'El email no tiene un formato válido.';
        }

        if (empty($this->password)) {
            $this->errors[] = 'La contraseña es obligatoria.';
        }

        return empty($this->errors);
    }
}
