<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripadvisorinnercardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tripadvisorinnercard', function (Blueprint $table) {
            $table->string('cardLink', 100)->index('pk_fk_cardLink');
            $table->string('innerCardTitle', 55);
            $table->string('innerCardAddress', 50);
            $table->double('ratingSentimentPoints');
            $table->set('ratingSentimentFeed', ['pocoRecomendado', 'valoracionesVariadas', 'recomendado', 'muyRecomendado']);
            $table->primary(['cardLink']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tripadvisorinnercard');
    }
}
