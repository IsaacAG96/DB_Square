<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateShoppingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_list', function (Blueprint $table) {
            $table->id();
            $table->string('item', 255);
            $table->integer('quantity')->check('quantity > 0');
            $table->decimal('price', 10, 2)->check('price >= 0');
            $table->integer('weight_volume')->check('weight_volume > 0');
            $table->string('unit_of_measurement', 50)->nullable();
            $table->string('store', 100)->nullable();
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
        Schema::dropIfExists('shopping_list');
    }
}
