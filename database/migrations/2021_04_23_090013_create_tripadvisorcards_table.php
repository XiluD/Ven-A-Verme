<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripadvisorcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripadvisorcards', function (Blueprint $table) {
            $table->string('cardLink', 100)->primary();
            $table->string('placeLink', 100)->index('fk_placeLink');
            $table->string('cardTitle', 45);
            $table->string('cardSubtitle', 45);
            $table->string('cardImage', 100);
            $table->set('cardType', ['queVisitar', 'alojamiento', 'dondeComer']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tripadvisorcards');
    }
}
