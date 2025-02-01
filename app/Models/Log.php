<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = ['usuario_id', 'accion', 'descripcion', 'fecha_creacion', 'fecha_actualizacion'];
}
