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
        Schema::create('settings', function (Blueprint $table) {
            $table->comment('');
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->string('key');
            $table->string('label');
            $table->string('value');
            $table->timestamps();
        });


            DB::statement("INSERT INTO `settings` (`id`, `company_id`, `key`, `label`, `value`, `created_at`, `updated_at`) VALUES
            (1, 0, 'title', 'Site Title', 'POS', NULL, '2023-01-10 11:46:02'),
            (2, 0, 'phone', 'Phone', '2323432432', NULL, '2017-09-06 22:08:34'),
            (3, 0, 'email', 'Email', 'arfan67@gmail.com', NULL, '2017-09-06 22:08:34'),
            (4, 0, 'address', 'Address', '3rd Floor Street 6 Gali 5', NULL, '2017-08-16 03:53:13'),
            (5, 0, 'country', 'Country', 'PAK', NULL, '2017-08-16 03:53:13'),
            (6, 0, 'timing1', 'Monday To Saturday', '12PM to 12AM', NULL, '2017-09-18 18:19:33'),
            (7, 0, 'sunday', 'Sunday', 'Closed', NULL, '2017-09-18 18:19:34'),
            (8, 0, 'facebook', 'Facebook', 'https://www.facebook.com/cent040', NULL, '2017-10-03 15:35:48'),
            (9, 0, 'twitter', 'Twitter', 'https://www.twitter.com/cent040', NULL, '2017-10-03 15:35:48'),
            (10, 0, 'vat', 'VAT', '10', NULL, '2017-10-03 16:50:12'),
            (11, 0, 'delivery_cost', 'Delivery Cost', '1', NULL, '2017-10-03 15:35:48'),
            (12, 0, 'currency', 'Currency', '$', NULL, '2017-10-03 17:00:43'),
            (13, 0, 'lng', 'Longitude', '-73.9400', NULL, NULL),
            (14, 0, 'lat', 'Latitude', '40.6700', NULL, NULL),
            (15, 0, 'stripe', 'Stripe Payment', 'yes', NULL, '2017-11-25 06:25:29'),
            (16, 0, 'frontend', 'Hide Frontend', 'yes', NULL, '2017-11-25 06:26:00'),
            (19, 0, 'staff_allow_sales', 'Sales Staff to Complete Sales', 'yes', NULL, NULL),
            (20, 0, 'deadline_void', 'Void Deadline Days', '7', '2018-12-11 17:28:58', NULL),
            (37, 0, 'footer_text', 'Footer Text', '<h5>Food Store Restaurant</h5><p>Food Store RestaurantWe offer freshly cooked Nepali, Indian and Fusion Cuisine daily. We are located at 655 Washington Street in Norwood', NULL, '2021-08-19 11:42:48');");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
