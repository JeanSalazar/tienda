<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';

    protected $fillable = ['descripcion', 'fecha_creacion', 'fecha_actualizacion'];
}
