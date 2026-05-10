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

    public function eliminar(int $id): void
    {
        $this->cursoRepository->delete($id);
    }
}
