<?php

use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertisers extends Database
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('advertisers')) :
            static::$capsule::schema()->create('advertisers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('company_name');
                $table->string('corporate_email')->unique();
                $table->string('phone_number');
                $table->string('company_address');
                $table->string('cnpj')->unique();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->on('users')->onDelete('cascade')->nullable(false);
                $table->timestamps();
            });
        endif;

        // you can now build your migrations with schemas.
        // see: https://leafphp.dev/docs/mvc/schema.html
        // Schema::build('advertisers');
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        static::$capsule::schema()->dropIfExists('advertisers');
    }
}
