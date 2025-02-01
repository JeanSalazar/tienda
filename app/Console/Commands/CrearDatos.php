<?php

namespace App\Console\Commands;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Cupon;
use App\Models\Producto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CrearDatos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crear:datos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear Datos Basicos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rol = Rol::updateOrCreate([
            "descripcion" => "Administrador",
        ]);

        $usuario = Usuario::updateOrCreate(["correo" => "jkristofersa@gmail.com"], [
            "contrasena" => Hash::make("123456"),
            "nombres" => "Kristofer",
            "apellidos" => "Salazar",
            "rol_id" => $rol->id,
        ]);

        $cliente = Cliente::updateOrCreate(["usuario_id" => $usuario->id], [
            "celular" => "925966069",
            "nro_documento" => "73424492",
        ]);

        $categoria = Categoria::updateOrCreate(["descripcion" => "Laptops"]);

        $productos = Producto::updateOrCreate(["nombre" => "Laptop Dell"], [
            "descripcion" => "Laptop de alto rendimiento",
            "caracteristicas" => "Intel Core i7, 16GB RAM, SSD 512GB",
            "precio" => 2500,
            "stock" => 10,
            "categoria_id" => $categoria->id,
        ]);

        $productos = Producto::updateOrCreate(["nombre" => "Laptop HP"], [
            "descripcion" => "Laptop de alto rendimiento",
            "caracteristicas" => "Intel Core i7, 8GB RAM, SSD 1024GB",
            "precio" => 3000,
            "stock" => 5,
            "categoria_id" => $categoria->id,
        ]);

        $cupon = Cupon::updateOrCreate(["codigo" => "DESCUENTO50"], [
            "descripcion" => "Descuento del 50%",
            "tipo_descuento" => 1,
            "valor_descuento" => 50,
            "fecha_inicio" => "2024-02-01",
            "fecha_fin" => "2024-12-31",
            "usos_maximo" => 100,
        ]);
    }
}
