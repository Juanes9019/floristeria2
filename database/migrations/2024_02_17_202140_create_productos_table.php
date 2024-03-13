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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono');
            $table->string('correo');
            $table->string('ubicacion');
            $table->timestamps();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',30);
        });

        Schema::create('sub_categorias', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->timestamps();
        });


        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_categoria')->references('id')->on('categorias');
            $table->string('precio');
            $table->string('descripcion');
            $table->string('imagen');
            $table->timestamps();
        });

        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_producto')->references('id')->on('productos');
            $table->integer('cantidad')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('sub_categorias');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('inventario');
    }
};
