<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProgramListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_list', function (Blueprint $table) {
            $table->id();
            $table->string('program_name', 255);
            $table->string('category', 100)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('version', 50)->nullable();
            $table->string('developer', 255)->nullable();
            $table->date('release_date')->nullable();
            $table->decimal('price', 10, 2)->check('price >= 0')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_list');
    }
}
