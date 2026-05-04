<?php
namespace Jrs2a\TiendaCursos\Models;

class Curso
{
    public int    $id;
    public string $title;
    public string $description;
    public float  $price;
    public string $imageUrl;

    public function __construct(array $data)
    {
        $this->id = (int)   $data['id'];
        $this->title = (string)$data['title'];
        $this->description = (string)$data['description'];
        $this->price = (float) $data['price'];
        $this->imageUrl = (string)($data['image_url'] ?? $data['imagen']);
    }

    public function getPrecioFormateado(): string
    {
        return number_format($this->price, 2, ',', '.') . ' €';
    }
}