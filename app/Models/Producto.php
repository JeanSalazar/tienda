<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['nombre', 'descripcion', 'caracteristicas', 'precio', 'categoria_id', 'fecha_creacion', 'fecha_actualizacion'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
