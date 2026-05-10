<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Repositories\CompraRepository;
use Jrs2a\TiendaCursos\Repositories\CursoRepository;

class CompraService
{
    private CompraRepository $compraRepository;
    private CursoRepository $cursoRepository;

    public function __construct()
    {
        $this->compraRepository = new CompraRepository();
        $this->cursoRepository = new CursoRepository();
    }

    public function obtenerCursosDeUsuario(int $userId): array
    {
        return $this->compraRepository->findByUser($userId);
    }

    public function asignar(int $userId, int $courseId): string
    {
        if ($this->compraRepository->exists($userId, $courseId)) {
            return 'already_owned';
        }

        if ($this->cursoRepository->decreaseStock($courseId)) {

            $inserted = $this->compraRepository->add($userId, $courseId);

            if (!$inserted) {
                $this->cursoRepository->increaseStock($courseId);

                return 'error';
            }

            return 'success';
        }

        return 'no_stock';
    }

    public function quitar(int $userId, int $courseId): void
    {
        if ($this->compraRepository->exists($userId, $courseId)) {
            $this->compraRepository->remove($userId, $courseId);
            $this->cursoRepository->increaseStock($courseId);
        }
    }

    public function usuarioTieneCurso(int $userId, int $courseId): bool
    {
        return $this->compraRepository->exists($userId, $courseId);
    }
}
