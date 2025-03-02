<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    use HasFactory;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    
    protected $table = 'ubigeos';

    protected $fillable = ['ubigeo_reniec', 'departamento', 'provincia', 'distrito', 'fecha_creacion', 'fecha_actualizacion'];
}
