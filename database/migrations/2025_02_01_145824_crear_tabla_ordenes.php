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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();

            $table->dateTime("fecha_compra");
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('cupon_id')
                ->nullable()
                ->constrained('cupones')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->decimal('importe_preliminar', 8, 2);
            $table->decimal('importe_total', 8, 2);
            $table->decimal('importe_igv', 8, 2);
            $table->decimal('importe_venta', 8, 2);
            $table->decimal('importe_descuento', 8, 2);

            $table->enum("estado", [1, 2, 3])->default(1);  // 1: Pendiente de Pago, 2: Pagado, 3: Enviado

            $table->dateTime("fecha_creacion");
            $table->dateTime("fecha_actualizacion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
