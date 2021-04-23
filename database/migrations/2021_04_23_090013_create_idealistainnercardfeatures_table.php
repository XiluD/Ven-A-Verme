<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdealistainnercardfeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idealistainnercardfeatures', function (Blueprint $table) {
            $table->string('cardLink', 100)->index('pk_fk_cardLink');
            $table->string('featureData', 45);
            $table->set('featureType', ['basic', 'building', 'equipment']);
            $table->primary(['cardLink', 'featureData']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('idealistainnercardfeatures');
    }
}
