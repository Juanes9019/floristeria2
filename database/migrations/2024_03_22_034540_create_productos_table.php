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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categoria')->references('id')->on('categorias');
            $table->string("nombre");
            $table->text('descripcion');
            $table->integer('cantidad')->default(0);
            $table->decimal('precio', 10, 2);
            $table->text('foto')->nullable();
            $table->integer('estado')->default(1); //1-Activo   0-Inactivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
