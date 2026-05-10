<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Repositories\CarritoRepository;
use Jrs2a\TiendaCursos\Repositories\CursoRepository;
use Jrs2a\TiendaCursos\Repositories\CompraRepository;

class CarritoService
{
    private CarritoRepository $carritoRepository;
    private CursoRepository $cursoRepository;
    private CompraRepository $compraRepository;

    public function __construct()
    {
        $this->carritoRepository = new CarritoRepository();
        $this->cursoRepository = new CursoRepository();
        $this->compraRepository = new CompraRepository();
    }
    /**
     * Devuelve el contenido del carrito y el total calculado.
     *
     * @param int $userId
     * @return array{courses: Curso[], total: float}
     */
    public function obtenerCarrito(int $userId): array
    {
        $courses = $this->carritoRepository->findByUser($userId);
        $total   = array_sum(array_map(fn($c) => $c->price, $courses));

        return ['courses' => $courses, 'total' => $total];
    }

    public function agregar(int $userId, int $courseId): string
    {
        if ($this->compraRepository->exists($userId, $courseId)) {
            return 'already_owned';
        }

        $this->carritoRepository->add($userId, $courseId);

        return 'success';
    }

    public function eliminar(int $userId, int $courseId): void
    {
        $this->carritoRepository->remove($userId, $courseId);
    }

    public function todosDisponibles(int $userId): bool
    {
        $courses = $this->carritoRepository->findByUser($userId);

        foreach ($courses as $course) {
            if ($course->stock <= 0) {
                return false;
            }
        }

        return true;
    }

    public function comprobarDescuento(int $userId): bool
    {
        $courses = $this->carritoRepository->findByUser($userId);
        if ($courses >= 3) {
            return min($courses);
        }

        return 0;
    }
    public function vaciar(int $userId): void
    {
        $this->carritoRepository->clearByUser($userId);
    }

    public function obtenerCourseIds(int $userId): array
    {
        return $this->carritoRepository->findCourseIdsByUser($userId);
    }
}
