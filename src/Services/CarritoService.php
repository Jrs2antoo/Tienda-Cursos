<?php
namespace Jrs2a\TiendaCursos\Services;

use Jrs2a\TiendaCursos\Repositories\CarritoRepository;

class CarritoService
{
    private CarritoRepository $carritoRepository;

    public function __construct()
    {
        $this->carritoRepository = new CarritoRepository();
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

    public function agregar(int $userId, int $courseId): void
    {
        $this->carritoRepository->add($userId, $courseId);
    }

    public function eliminar(int $userId, int $courseId): void
    {
        $this->carritoRepository->remove($userId, $courseId);
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