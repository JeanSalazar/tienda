<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $table = 'direcciones';

    protected $fillable = ['direccion', 'ubigeo_id', 'referencia', 'cliente_id', 'fecha_creacion', 'fecha_actualizacion'];
}
