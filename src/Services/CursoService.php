<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Models\Curso;
use Jrs2a\TiendaCursos\Repositories\CursoRepository;

class CursoService
{
    private CursoRepository $cursoRepository;

    public function __construct()
    {
        $this->cursoRepository = new CursoRepository();
    }

    /** @return Curso[] */
    public function obtenerTodos(): array
    {
        return $this->cursoRepository->findAll();
    }

    /** @return Curso[] Incluye inactivos — solo para el panel admin */
    public function obtenerTodosAdmin(): array
    {
        return $this->cursoRepository->findAllAdmin();
    }

    /** @return Curso[] */
    public function obtenerDestacados(int $limit = 2): array
    {
        return $this->cursoRepository->findAllLimit($limit);
    }

    public function obtenerPorId(int $id): ?Curso
    {
        return $this->cursoRepository->findById($id);
    }

    public function crear(string $title, string $description, float $price, int $stock, string $imageUrl): bool
    {
        return $this->cursoRepository->create($title, $description, $price, $stock, $imageUrl);
    }

    public function actualizar(int $id, string $title, string $description, float $price, int $stock, string $imageUrl): bool
    {
        return $this->cursoRepository->update($id, $title, $description, $price, $stock, $imageUrl);
    }

    /** Borrado lógico: desactiva el curso sin eliminar compras históricas */
    public function eliminar(int $id): void
    {
        $this->cursoRepository->desactivar($id);
    }

    /** Reactiva un curso previamente desactivado */
    public function reactivar(int $id): void
    {
        $this->cursoRepository->activar($id);
    }
}