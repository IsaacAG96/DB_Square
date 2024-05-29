<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompartirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compartir', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_tabla', 255);
            $table->integer('propietario');
            $table->integer('usuario_compartido');
            $table->boolean('visualizar');
            $table->boolean('editar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compartir');
    }
}
