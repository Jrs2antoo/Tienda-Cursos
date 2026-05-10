<?php
namespace Jrs2a\TiendaCursos\Models;
/**
 * Representa un curso disponible en la tienda.
 *
 * @property int    $id
 * @property string $fullName;
 * @property string $email;
 * @property string $role;
 * @property string $password;
 * @property string $token;
 * @property int $tokenExp;
 * @property bool $confirmado;
 * @property string $createdAt;
 */
class Usuario
{
    public int    $id;
    public string $fullName;
    public string $email;
    public string $role;
    public string $password;
    public string $token;
    public int    $tokenExp;
    public bool   $confirmado;
    public string $createdAt;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->fullName = (string)$data['full_name'];
        $this->email = (string)$data['email'];
        $this->role = (string)($data['role']       ?? 'user');
        $this->password = (string)($data['password']   ?? '');
        $this->token = (string)($data['token']      ?? '');
        $this->tokenExp = (int) ($data['token_exp']  ?? 0);
        $this->confirmado = (bool)($data['confirmado'] ?? false);
        $this->createdAt = (string)($data['created_at'] ?? '');
    }

    public function estaConfirmado(): bool
    {
        return $this->confirmado;
    }
}