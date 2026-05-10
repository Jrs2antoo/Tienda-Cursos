<?php
namespace Jrs2a\TiendaCursos\Models;
/**
 * Representa un curso disponible en la tienda.
 *
 * @property int $id
 * @property int $userId
 * @property string $courseId
 */
class Compra
{
    public int $id;
    public int $userId;
    public int $courseId;

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->userId = (int)$data['user_id'];
        $this->courseId = (int)$data['course_id'];
    }
}