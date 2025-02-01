<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenProducto extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    

    protected $table = 'ordenes_productos';

    protected $fillable = ['producto_id', 'orden_id', 'cantidad', 'fecha_creacion', 'fecha_actualizacion'];
}
