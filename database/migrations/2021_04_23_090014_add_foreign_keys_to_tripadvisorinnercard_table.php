<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTripadvisorinnercardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tripadvisorinnercard', function (Blueprint $table) {
            $table->foreign('cardLink', 'tripadvisorinnercard_ibfk_1')->references('cardLink')->on('tripadvisorcards')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tripadvisorinnercard', function (Blueprint $table) {
            $table->dropForeign('tripadvisorinnercard_ibfk_1');
        });
    }
}
