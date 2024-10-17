<?php

use Leaf\Schema;
use Leaf\Database;
use Illuminate\Database\Schema\Blueprint;

class CreateEbooks extends Database
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        if (!static::$capsule::schema()->hasTable('ebooks')) :
            static::$capsule::schema()->create('ebooks', function (Blueprint $table) {
                $table->increments('id');
                $table->string('category');
                $table->string('author');
                $table->integer('age');
                $table->string('title');
                $table->string('target_audience');
                $table->string('description');
                $table->string('cover');
                $table->integer('quantity_ebook');
                $table->float('price');
                $table->unsignedBigInteger('advertiser_id');
                $table->foreign('advertiser_id')->on('advertisers')->onDelete('cascade')->nullable(false);
                $table->timestamps();
            });
        endif;

        // you can now build your migrations with schemas.
        // see: https://leafphp.dev/docs/mvc/schema.html
        // Schema::build('ebooks');
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        static::$capsule::schema()->dropIfExists('ebooks');
    }
}
