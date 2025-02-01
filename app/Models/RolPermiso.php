<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    
    protected $table = 'roles_permisos';

    protected $fillable = ['permiso_id', 'rol_id', 'fecha_creacion', 'fecha_actualizacion'];
}
