<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Repositories\CompraRepository;

class CompraService
{
    private CompraRepository $compraRepository;

    public function __construct()
    {
        $this->compraRepository = new CompraRepository();
    }

    public function obtenerCursosDeUsuario(int $userId): array
    {
        return $this->compraRepository->findByUser($userId);
    }

    public function asignar(int $userId, int $courseId): void
    {
        if (!$this->compraRepository->exists($userId, $courseId)) {
            $this->compraRepository->add($userId, $courseId);
        }
    }

    public function quitar(int $userId, int $courseId): void
    {
        $this->compraRepository->remove($userId, $courseId);
    }
}
