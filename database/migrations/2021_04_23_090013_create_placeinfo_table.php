<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeinfo', function (Blueprint $table) {
            $table->string('placeLink', 100);
            $table->string('provincia', 45);
            $table->string('municipio', 45);
            $table->set('linkType', ['tripadvisor', 'idealista']);
            $table->date('expirationDate');
            $table->index(['provincia', 'municipio'], 'fk_prov_mun');
            $table->primary(['placeLink', 'municipio']);

        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('placeinfo');
    }
}
