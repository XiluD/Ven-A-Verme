<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIdeainnercardimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideainnercardimages', function (Blueprint $table) {
            $table->foreign('cardLink', 'ideainnercardimages_ibfk_1')->references('cardLink')->on('idealistainnercard')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideainnercardimages', function (Blueprint $table) {
            $table->dropForeign('ideainnercardimages_ibfk_1');
        });
    }
}
