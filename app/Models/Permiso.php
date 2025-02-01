<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permiso extends Model
{
    use HasFactory;


    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $table = 'permisos';

    protected $fillable = ['descripcion', 'fecha_creacion', 'fecha_actualizacion'];

    // Relación muchos a muchos con roles
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_permiso');
    }
}
