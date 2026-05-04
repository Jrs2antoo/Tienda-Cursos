<?php
namespace Jrs2a\TiendaCursos\Core;
class Pages
{/**
 * Renderiza una vista envuelta en el layout (header + view + footer).
 *
 * @param string               $pageName  Ruta relativa a Views/ sin extensión (ej: 'admin/cursos')
 * @param array<string, mixed> $params    Variables que se inyectan en la vista via extract()
 */
    public static function render(string $pageName, array $params = []): void
    {
        extract($params);

        $viewPath = dirname(__DIR__);
        require $viewPath . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "Layout" . DIRECTORY_SEPARATOR . "header.php";
        require $viewPath . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "$pageName.php";
        require $viewPath . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "Layout" . DIRECTORY_SEPARATOR . "footer.php";
    }
}
