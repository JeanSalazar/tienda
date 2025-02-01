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
        Schema::create('cupones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion');

            $table->enum("tipo_descuento", [1, 2])->default(1);  // 1: porcentaje, 2: Fijo
            $table->decimal('valor_descuento', 8, 2);

            $table->date("fecha_inicio");
            $table->date("fecha_fin");

            $table->integer('usos_maximo')->default(0);
            $table->integer('usos_actuales')->default(0);

            $table->dateTime("fecha_creacion");
            $table->dateTime("fecha_actualizacion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupones');
    }
};
