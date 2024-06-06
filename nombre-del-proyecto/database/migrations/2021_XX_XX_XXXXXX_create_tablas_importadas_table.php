<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablasImportadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablas_importadas', function (Blueprint $table) {
            $table->id();
            $table->string('tabla_importada')->nullable(false);
            $table->unsignedBigInteger('id_propietario')->nullable(false);
            $table->timestamps();

            // Foreign key constraint (assuming there is a users table)
            $table->foreign('id_propietario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tablas_importadas');
    }
}
