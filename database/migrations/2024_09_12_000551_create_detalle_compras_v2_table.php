<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleComprasV2Table extends Migration
{
    public function up()
    {
        Schema::create('detalle_compras_v2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_insumo')->constrained('insumos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('costo_unitario', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('total', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_compras_v2');
    }
}
