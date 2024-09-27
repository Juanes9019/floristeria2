<?php

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generar_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_insumo')->constrained('insumos');
            $table->foreignId('id_producto')->constrained('productos');
            $table->integer('cantidad_utilizada');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generar_productos');
    }
};