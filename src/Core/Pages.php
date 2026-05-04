<?php
namespace Jrs2a\TiendaCursos\Core;
class Pages
{
    public static function render(string $pageName, array $params = []): void
    {
        extract($params);

        $viewPath = dirname(__DIR__);
        require $viewPath . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "Layout" . DIRECTORY_SEPARATOR . "header.php";
        require $viewPath . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "$pageName.php";
        require $viewPath . DIRECTORY_SEPARATOR . "Views" . DIRECTORY_SEPARATOR . "Layout" . DIRECTORY_SEPARATOR . "footer.php";
    }
}
