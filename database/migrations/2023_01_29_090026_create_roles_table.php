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
        Schema::create('roles', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::statement("INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
        (1, 'admin', 'Administrator', 'tis is isafds', NULL, '2023-01-22 09:42:46'),
        (2, 'manager', 'Sales Manager', NULL, NULL, '2023-01-22 09:43:47'),
        (3, 'sales_staff', 'Waitress', NULL, NULL, '2021-08-19 13:28:24');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
