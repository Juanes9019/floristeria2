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
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pedido')->references('id')->on('pedidos');
            $table->foreignId('id_producto')->nullable()->constrained('productos');
            $table->decimal('precio', 10, 2);
            $table->integer('cantidad');
            $table->decimal('subtotal', 10, 2);
            $table->string('imagen')->nullable();
            $table->json('opciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
