<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    
    protected $table = 'resenas';
        
    protected $fillable = ['producto_id', 'cliente_id', 'calificacion', 'comentario','fecha_creacion', 'fecha_actualizacion'];
}
