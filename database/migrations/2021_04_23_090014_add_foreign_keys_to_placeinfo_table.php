<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPlaceinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placeinfo', function (Blueprint $table) {
            $table->foreign(['provincia', 'municipio'], 'placeinfo_ibfk_1')->references(['provincia', 'municipio'])->on('place')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('placeinfo', function (Blueprint $table) {
            $table->dropForeign('placeinfo_ibfk_1');
        });
    }
}
