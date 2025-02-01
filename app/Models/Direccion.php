<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';

    protected $fillable = ['direccion', 'ubigeo_id', 'referencia', 'pais', 'cliente_id', 'fecha_creacion', 'fecha_actualizacion'];
}
