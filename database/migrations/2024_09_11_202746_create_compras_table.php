<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    public function up()
    {
        schema::create('compras', function (Blueprint $table) {    
        $table->bigIncrements('id');   
        $table->unsignedBigInteger('id_proveedor');    
        $table->decimal('costo_total', 8, 2);    
        $table->timestamps();    
        $table->foreign('id_proveedor')->references('id')->on('proveedores')->onDelete('cascade');
        $table->string('estado')->default('Activa'); // O 'inactiva'
    });
}

    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['id_proveedor']);
            $table->dropColumn('id_proveedor');
            $table->dropColumn('estado');

        });
    }
}
