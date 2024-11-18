<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categoria_insumo')->constrained('categoria_insumos');
            $table->string('nombre');
            $table->string('color')->nullable();
            $table->integer('cantidad_insumo')->default(0); 
            $table->decimal('costo_unitario', 10, 2);
            $table->string('imagen')->nullable(); 
            $table->string('descripcion')->nullable();  
            $table->integer('estado')->default(1);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
