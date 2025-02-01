<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['nombre', 'descripcion', 'stock', 'caracteristicas', 'precio', 'categoria_id', 'fecha_creacion', 'fecha_actualizacion'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function ordenes()
    {
        return $this->belongsToMany(Orden::class, 'ordenes_productos')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
}
