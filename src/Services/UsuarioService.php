<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Core\Security;
use Jrs2a\TiendaCursos\Models\Usuario;
use Jrs2a\TiendaCursos\Repositories\UsuarioRepository;

class UsuarioService
{
    private UsuarioRepository $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository();
    }

    /** @return Usuario[] */
    public function obtenerTodos(): array
    {
        return $this->usuarioRepository->findAll();
    }

    public function obtenerPorId(int $id): ?Usuario
    {
        return $this->usuarioRepository->findById($id);
    }

    public function obtenerPorEmail(string $email): ?Usuario
    {
        return $this->usuarioRepository->findByEmail($email);
    }

    public function emailExiste(string $email): bool
    {
        return $this->obtenerPorEmail($email) !== null;
    }

    public function registrar(string $fullName, string $email, string $password): array
    {
        $passwordHash = Security::encryptPassw($password);
        $token        = Security::createToken(Security::secretKey(), ['mail' => $email]);
        $tokenExp     = time() + 60;

        $success = $this->usuarioRepository->create($fullName, $email, $passwordHash, $token, $tokenExp);

        return ['success' => $success, 'token' => $token];
    }

    public function confirmarCuenta(string $token): bool
    {
        $user = $this->usuarioRepository->findByToken($token);

        if (!$user) return false;
        if (time() > $user->tokenExp) return false;
        if (!Security::validateToken($token)) return false;

        $this->usuarioRepository->confirmar($user->id);
        return true;
    }

    public function validarLogin(string $email, string $password): ?Usuario
    {
        $user = $this->usuarioRepository->findByEmail($email);

        if (!$user) return null;
        if (!Security::validatePassw($password, $user->password)) return null;
        if (!$user->estaConfirmado()) return null;

        return $user;
    }

    public function actualizar(int $id, string $fullName, string $email, string $role, ?string $password = null): bool
    {
        $passwordHash = $password ? password_hash($password, PASSWORD_DEFAULT) : null;
        return $this->usuarioRepository->update($id, $fullName, $email, $role, $passwordHash);
    }

    public function eliminar(int $id, int $adminId): bool
    {
        if ($id === $adminId) return false;
        $this->usuarioRepository->delete($id);
        return true;
    }

    public function obtenerTodosConCursos(): array
    {
        return $this->usuarioRepository->findAllConCursos();
    }
}