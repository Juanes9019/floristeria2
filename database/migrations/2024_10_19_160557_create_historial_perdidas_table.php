<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('historial_perdidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insumo_id');  
            $table->integer('cantidad_perdida');    
            $table->timestamp('fecha_perdida');     
            $table->timestamps();
    
            // Relaciones
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_perdidas');
    }
};
