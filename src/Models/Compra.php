<?php
namespace Jrs2a\TiendaCursos\Models;

class Compra
{
    public int $id;
    public int $userId;
    public int $courseId;

    public function __construct(array $data)
    {
        $this->id       = (int)$data['id'];
        $this->userId   = (int)$data['user_id'];
        $this->courseId = (int)$data['course_id'];
    }
}