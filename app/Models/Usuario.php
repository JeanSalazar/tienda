<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // O Laravel\Passport\HasApiTokens según el caso
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, Notifiable, HasFactory, HasRoles;

    protected $fillable = ['nombre', 'correo', 'apellido', 'celular', 'contrasena'];
    protected $hidden = ['contrasena'];

    // Método para obtener la contraseña hasheada
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}