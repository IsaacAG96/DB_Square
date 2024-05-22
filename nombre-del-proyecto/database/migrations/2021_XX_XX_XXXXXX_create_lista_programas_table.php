<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateListaProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_programas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_programa', 255);
            $table->string('categoria', 100)->nullable();
            $table->string('plataforma', 100)->nullable();
            $table->string('version', 50)->nullable();
            $table->string('desarrollador', 255)->nullable();
            $table->date('fecha_lanzamiento')->nullable();
            $table->decimal('precio', 10, 2)->check('precio >= 0')->nullable();
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
        Schema::dropIfExists('lista_programas');
    }
}
