<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // O Laravel\Passport\HasApiTokens según el caso


class Usuario extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'usuarios';
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['nombres', 'correo', 'apellidos', 'estado', 'contrasena', 'rol_id', 'fecha_creacion', 'fecha_actualizacion'];
    protected $hidden = ['contrasena'];

    // Método para obtener la contraseña hasheada
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
