<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->integer('supplier_id')->nullable();
            $table->integer('product_id');
            $table->string('type', 10)->nullable();
            $table->integer('quantity');
            $table->string('track_type', 55);
            $table->timestamps();
            $table->string('comments', 500)->nullable();
            $table->integer('storeroom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
