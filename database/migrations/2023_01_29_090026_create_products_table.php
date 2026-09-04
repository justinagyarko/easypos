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
        Schema::create('products', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->integer('category_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('titles')->nullable();
            $table->string('prices');
            $table->string('qty')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('is_delete')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->integer('warehouse')->nullable();
            $table->integer('min_qty')->nullable();
            $table->integer('store_min')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
