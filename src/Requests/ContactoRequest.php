<?php
namespace Jrs2a\TiendaCursos\Requests;

class ContactoRequest
{
    public string $nombre;
    public string $email;
    public string $asunto;
    public string $mensaje;
    public array $errors = [];

    public function __construct(array $post)
    {
        $this->nombre  = htmlspecialchars(trim($post['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
        $this->email   = trim(filter_var($post['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $this->asunto  = htmlspecialchars(trim($post['asunto'] ?? ''), ENT_QUOTES, 'UTF-8');
        $this->mensaje = htmlspecialchars(trim($post['mensaje'] ?? ''), ENT_QUOTES, 'UTF-8');
    }

    public function isValid(): bool
    {
        if (empty($this->nombre)) {
            $this->errors[] = 'El nombre es obligatorio.';
        }

        if (empty($this->email)) {
            $this->errors[] = 'El email es obligatorio.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'El email no tiene un formato válido.';
        }

        if (empty($this->asunto)) {
            $this->errors[] = 'El asunto es obligatorio.';
        }

        if (empty($this->mensaje)) {
            $this->errors[] = 'El mensaje es obligatorio.';
        }

        return empty($this->errors);
    }
}
