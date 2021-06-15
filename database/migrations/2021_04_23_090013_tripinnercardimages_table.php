<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TripinnercardimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('tripinnercardimages', function (Blueprint $table) {
            $table->string('imageLink', 300)->primary();
            $table->string('cardLink', 100)->index('fk_cardLink');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tripinnercardimages');
    }
}
