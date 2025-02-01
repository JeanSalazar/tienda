<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $table = 'inventario';

    protected $fillable = ['producto_id', 'cantidad', 'fecha_creacion', 'fecha_actualizacion'];
}
