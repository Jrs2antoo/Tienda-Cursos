<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Jrs2a\TiendaCursos\Core\Pages;
use Jrs2a\TiendaCursos\Services\CursoService;

class CourseController
{
    private CursoService $cursoService;
    private Pages $pages;

    public function __construct()
    {
        $this->cursoService = new CursoService();
        $this->pages        = new Pages();
    }

    public function index(): void
    {
        $courses = $this->cursoService->obtenerTodos();
        $this->pages->render("Cursos/cursos", compact('courses'));
    }
}
