<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIdealistainnercardfeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('idealistainnercardfeatures', function (Blueprint $table) {
            $table->foreign('cardLink', 'idealistainnercardfeatures_ibfk_1')->references('cardLink')->on('idealistainnercard')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('idealistainnercardfeatures', function (Blueprint $table) {
            $table->dropForeign('idealistainnercardfeatures_ibfk_1');
        });
    }
}
