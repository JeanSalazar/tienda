<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $fillable = ['nombre', 'correo', 'contrasena'];
    protected $hidden = ['contrasena'];

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }
}
