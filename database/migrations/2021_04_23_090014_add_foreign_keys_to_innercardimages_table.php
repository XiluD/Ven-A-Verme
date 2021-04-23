<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToInnercardimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('innercardimages', function (Blueprint $table) {
            $table->foreign('cardLink', 'innercardimages_ibfk_1')->references('cardLink')->on('tripadvisorinnercard')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('cardLink', 'innercardimages_ibfk_2')->references('cardLink')->on('idealistainnercard')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('innercardimages', function (Blueprint $table) {
            $table->dropForeign('innercardimages_ibfk_1');
            $table->dropForeign('innercardimages_ibfk_2');
        });
    }
}
