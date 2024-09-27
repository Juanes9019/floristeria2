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
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categoria_insumo')->constrained('categoria_insumos');
            $table->string('nombre');
            $table->integer('cantidad_insumo')->default(0);
            $table->decimal('costo_unitario', 10, 2);
            $table->integer('perdida_insumo');            
            $table->decimal('costo_perdida', 10, 2);
            $table->integer('estado')->default(1); //1-Activo   0-Inactivo
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
