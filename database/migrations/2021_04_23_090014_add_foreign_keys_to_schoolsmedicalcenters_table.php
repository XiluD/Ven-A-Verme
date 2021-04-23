<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSchoolsmedicalcentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schoolsmedicalcenters', function (Blueprint $table) {
            $table->foreign(['provincia', 'municipio'], 'schoolsmedicalcenters_ibfk_1')->references(['provincia', 'municipio'])->on('place')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schoolsmedicalcenters', function (Blueprint $table) {
            $table->dropForeign('schoolsmedicalcenters_ibfk_1');
        });
    }
}
