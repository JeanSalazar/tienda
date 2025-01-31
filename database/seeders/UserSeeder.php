<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 10 usuarios de prueba
        Usuario::factory(10)->create();

        // Crear un usuario admin por defecto
        /*Usuario::create([
            'nombre' => 'Admin',
            'correo' => 'admin@example.com',
            'contrasena' => Hash::make('admin123'), // Cambia la contraseña si es necesario
        ]);*/
    }
}
