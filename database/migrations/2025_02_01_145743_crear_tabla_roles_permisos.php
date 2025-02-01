<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rol_permiso', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rol_id')
                ->nullable()
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('permiso_id')
                ->nullable()
                ->constrained('permisos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // Cambiar a timestamp para manejar automáticamente las fechas
            $table->timestamp('fecha_creacion')->useCurrent(); // Establecer la fecha actual por defecto para fecha_creacion
            $table->timestamp('fecha_actualizacion')->useCurrent()->nullable()->onUpdate(DB::raw('CURRENT_TIMESTAMP')); // Actualizar automáticamente fecha_actualizacion

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_permiso');
    }
};
