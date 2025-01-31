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

        // Crear un usuario admin por defecto (si no existe)
        Usuario::firstOrCreate(
            ['correo' => 'jkristofersa@gmail.com'], // Atributos para buscar
            [ // Atributos para crear si no existe
                'nombre' => 'Kristofer',
                'apellido' => 'Salazar',
                'celular' => '925966069',
                'correo' => 'jkristofersa@gmail.com',
                'contrasena' => Hash::make('admin123'),
            ]
        );
    }
}
