<?php
namespace Jrs2a\TiendaCursos\Models;
/**
 * Representa un curso disponible en la tienda.
 *
 * @property int    $id
 * @property string $title
 * @property string $description
 * @property float  $price
 * @property int    $stock
 * @property string $imageUrl
 */
class Curso
{
    public int    $id;
    public string $title;
    public string $description;
    public float  $price;
    public int    $stock;
    public string $imageUrl;

    public function __construct(array $data)
    {
        $this->id = (int)   $data['id'];
        $this->title = (string)$data['title'];
        $this->description = (string)$data['description'];
        $this->price = (float) $data['price'];
        $this->stock = (int)($data['stock'] ?? 0);
        $this->imageUrl = (string)($data['image_url'] ?? $data['imagen']);
    }
}
