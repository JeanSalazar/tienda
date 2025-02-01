<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'caracteristicas', 'precio', 'categoria_id', 'fecha_creacion', 'fecha_actualizacion'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function getIgvAttribute()
    {
        return $this->precio_base * 0.18;
    }

    public function getPrecioFinalAttribute()
    {
        return $this->precio_base + $this->igv;
    }
}
