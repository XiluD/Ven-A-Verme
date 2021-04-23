<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTripadvisorcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tripadvisorcards', function (Blueprint $table) {
            $table->foreign('placeLink', 'tripadvisorcards_ibfk_1')->references('placeLink')->on('placeinfo')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tripadvisorcards', function (Blueprint $table) {
            $table->dropForeign('tripadvisorcards_ibfk_1');
        });
    }
}
