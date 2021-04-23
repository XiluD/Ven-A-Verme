<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIdealistainnercardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('idealistainnercard', function (Blueprint $table) {
            $table->foreign('cardLink', 'idealistainnercard_ibfk_1')->references('cardLink')->on('idealistacards')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idealistainnercard', function (Blueprint $table) {
            $table->dropForeign('idealistainnercard_ibfk_1');
        });
    }
}
