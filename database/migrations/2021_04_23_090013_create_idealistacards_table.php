<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdealistacardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idealistacards', function (Blueprint $table) {
            $table->string('cardLink', 100)->primary();
            $table->string('placeLink', 100)->index('fk_placeLink');
            $table->string('cardTitle', 55);
            $table->string('cardPrice', 50);
            $table->string('cardDetail', 100);
            $table->string('cardDescription', 500);
            $table->string('cardContact', 20);
            $table->string('cardImage', 300);
            $table->set('cardType', ['onRent', 'onSale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('idealistacards');
    }
}
