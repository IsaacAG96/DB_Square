<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateListaCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_compra', function (Blueprint $table) {
            $table->id();
            $table->string('articulo', 255);
            $table->integer('cantidad')->check('cantidad > 0');
            $table->decimal('precio', 10, 2)->check('precio >= 0');
            $table->integer('peso_volumen')->check('peso_volumen > 0');
            $table->string('unidad_de_medida', 50)->nullable();
            $table->string('tienda', 100)->nullable();
            $table->timestamp('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ultima_modificacion')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('id_propietario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_compra');
    }
}
