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
            $table->string('cardTitle', 45);
            $table->integer('cardPrice');
            $table->string('cardDetail', 100);
            $table->string('cardDescription', 300);
            $table->integer('cardContact');
            $table->string('cardImage', 100);
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
