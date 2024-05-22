<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateColeccionDiscosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coleccion_discos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->string('artista', 255)->nullable();
            $table->string('genero', 100)->nullable();
            $table->integer('año_lanzamiento')->nullable();
            $table->string('sello_discografico', 100)->nullable();
            $table->string('codigo_isrc', 20)->nullable();
            $table->timestamp('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ultima_modificacion')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('permiso_visualizar');
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
        Schema::dropIfExists('coleccion_discos');
    }
}
