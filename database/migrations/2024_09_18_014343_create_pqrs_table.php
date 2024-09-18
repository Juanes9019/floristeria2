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
        Schema::create('pqrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->enum('estado', ["Nuevo", "Respondido"])->default("Nuevo");
            $table->timestamp('fecha_envio');
            $table->enum('tipo', ["Peticiones","Quejas","Reclamos","Sugerencia"]);
            $table->enum('motivo', ['Reembolso','Error en la página','Producto defectuoso',
                'Entrega tardía','Atención al cliente','Problema con el pago','Quejas sobre el servicio',
                'Sugerencia de mejora','Solicitud de cambio de producto','Cancelación de pedido',
                'Otros'
            ]);
            $table->text('descripcion');
            $table->text('respuesta')->nullable(); 
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pqrs');
    }
};
