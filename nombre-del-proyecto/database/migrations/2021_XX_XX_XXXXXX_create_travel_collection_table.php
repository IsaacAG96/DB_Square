<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTravelCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_collection', function (Blueprint $table) {
            $table->id();
            $table->string('destination', 255);
            $table->integer('duration')->check('duration > 0');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('purpose', 255)->nullable();
            $table->decimal('expenses', 10, 2)->check('expenses >= 0');
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
        Schema::dropIfExists('travel_collection');
    }
}
