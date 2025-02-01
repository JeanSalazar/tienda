<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Rol extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $table = 'roles';


    protected $fillable = ['descripcion', 'fecha_creacion', 'fecha_actualizacion'];

    // Relación muchos a muchos con permisos
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'rol_permiso');
    }
}
