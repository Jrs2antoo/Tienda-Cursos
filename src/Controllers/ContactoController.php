<?php
namespace Jrs2a\TiendaCursos\Controllers;

use Jrs2a\TiendaCursos\Core\Email;
use Jrs2a\TiendaCursos\Core\Pages;
use Jrs2a\TiendaCursos\Requests\ContactoRequest;

class ContactoController
{
    private Pages $pages;

    public function __construct()
    {
        $this->pages = new Pages();
    }

    public function index(): void
    {
        $this->pages->render("Contacto/contacto", []);
    }

    public function enviar(): void
    {
        $request = new ContactoRequest($_POST);

        if (!$request->isValid()) {
            $_SESSION['contacto_error'] = implode(' ', $request->errors);
            header("Location: /tiendaCursos/contacto");
            exit;
        }

        try {
            (new Email($request->email, $request->nombre))->enviarContacto($request->asunto, $request->mensaje);
            $_SESSION['contacto_ok'] = "¡Mensaje enviado correctamente! Te responderemos pronto.";
        } catch (\Exception $e) {
            $_SESSION['contacto_error'] = "Hubo un error al enviar el mensaje. Inténtalo de nuevo.";
        }

        header("Location: /tiendaCursos/contacto");
        exit;
    }
}
