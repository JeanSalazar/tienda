<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery', function (Blueprint $table) {
            $table->id();


            $table->foreignId('orden_id')
                ->nullable()
                ->constrained('ordenes')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('direccion_id')
                ->nullable()
                ->constrained('direcciones')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum("estado", [1, 2])->default(1);  // 1: Enviado, 2: Recibido

            $table->dateTime("fecha_envio");
            $table->dateTime("fecha_entrega_estimada");
            $table->dateTime("fecha_entrega_real")->nullable();

            $table->dateTime("fecha_creacion");
            $table->dateTime("fecha_actualizacion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
