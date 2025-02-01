<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    use HasFactory;

    protected $table = 'cupones';

    protected $fillable = ['codigo', 'descripcion', 'tipo_descuento', 'valor_descuento', 'fecha_inicio', 'fecha_fin', 'usos_maximo', 'usos_actuales', 'fecha_creacion', 'fecha_actualizacion'];
}
