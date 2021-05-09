<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTripInnercardimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tripinnercardimages', function (Blueprint $table) {
            $table->foreign('cardLink', 'tripinnercardimages_ibfk_1')->references('cardLink')->on('tripadvisorinnercard')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tripinnercardimages', function (Blueprint $table) {
            $table->dropForeign('tripinnercardimages_ibfk_1');
        });
    }
}
