<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIdealistacardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('idealistacards', function (Blueprint $table) {
            $table->foreign('placeLink', 'idealistacards_ibfk_1')->references('placeLink')->on('placeinfo')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idealistacards', function (Blueprint $table) {
            $table->dropForeign('idealistacards_ibfk_1');
        });
    }
}
