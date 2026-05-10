<?php
namespace Jrs2a\TiendaCursos\Requests;

class CursoRequest
{
    public int $id;
    public string $title;
    public string $description;
    public float $price;
    public int $stock;
    public string $imageUrl;
    public array $errors = [];

    public function __construct(array $post)
    {
        $this->id          = (int)($post['id'] ?? 0);
        $this->title       = htmlspecialchars(trim($post['title'] ?? ''), ENT_QUOTES, 'UTF-8');
        $this->description = htmlspecialchars(trim($post['description'] ?? ''), ENT_QUOTES, 'UTF-8');
        $this->price       = (float)($post['price'] ?? 0);
        $this->stock       = (int)($post['stock'] ?? 0);
        $this->imageUrl    = htmlspecialchars(trim($post['image_url'] ?? $post['img_url'] ?? ''), ENT_QUOTES, 'UTF-8');
    }

    public function isValid(): bool
    {
        if (empty($this->title)) {
            $this->errors[] = 'El título es obligatorio.';
        }

        if (empty($this->description)) {
            $this->errors[] = 'La descripción es obligatoria.';
        }

        if ($this->price <= 0) {
            $this->errors[] = 'El precio debe ser mayor que 0.';
        }

        if ($this->stock < 0) {
            $this->errors[] = 'El stock no puede ser negativo.';
        }

        return empty($this->errors);
    }
}
