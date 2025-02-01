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
        Schema::create('ordenes_productos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                ->nullable()
                ->constrained('productos')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('orden_id')
                ->nullable()
                ->constrained('ordenes')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->integer('cantidad');

            $table->dateTime("fecha_creacion");
            $table->dateTime("fecha_actualizacion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_productos');
    }
};
