<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportedTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imported_tables', function (Blueprint $table) {
            $table->id();
            $table->string('imported_table')->nullable(false);
            $table->unsignedBigInteger('owner_id')->nullable(false);
            $table->timestamps();

            // Foreign key constraint (assuming there is a users table)
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imported_tables');
    }
}
