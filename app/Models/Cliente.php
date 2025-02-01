<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $table = 'clientes';

    protected $fillable = ['usuario_id', 'nro_documento', 'celular', 'fecha_creacion', 'fecha_actualizacion'];

    // En el modelo Cliente (app/Models/Cliente.php)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class); // Asegúrate de que el modelo Usuario esté correctamente relacionado
    }
}
