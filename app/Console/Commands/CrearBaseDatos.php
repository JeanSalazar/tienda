<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrearBaseDatos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basedatos:crear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear la Estructura de la Base de Datos en orden';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $migrations = [
            '2019_12_14_000001_create_personal_access_tokens_table.php',
            '2025_02_01_145734_crear_tabla_permisos.php',
            '2025_02_01_145731_crear_tabla_roles.php',
            '2025_02_01_145743_crear_tabla_roles_permisos.php',
            '2025_02_01_145723_crear_tabla_usuarios.php',
            '2025_02_01_145720_crear_tabla_logs.php',
            '2025_02_01_145644_crear_tabla_ubigeos.php',
            '2025_02_01_145710_crear_tabla_clientes.php',
            '2025_02_01_145701_crear_tabla_direcciones.php',
            '2025_02_01_145805_crear_tabla_categorias.php',
            '2025_02_01_145751_crear_tabla_productos.php',
            '2025_02_01_145812_crear_tabla_resenas.php',
            '2025_02_01_145759_crear_tabla_inventario.php',
            '2025_02_01_145818_crear_tabla_cupones.php',
            '2025_02_01_145824_crear_tabla_ordenes.php',
            '2025_02_01_145829_crear_tabla_ordenes_productos.php',
            '2025_02_01_145833_crear_tabla_delivery.php',
            '2025_02_01_172736_create_password_reset_tokens_table.php'
        ];

        foreach ($migrations as $migration) {
            $basePath = 'database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath . $migrationName;
            $this->call('migrate:refresh', [
                '--path' => $path,
            ]);
        }

        return 0;
    }
}
