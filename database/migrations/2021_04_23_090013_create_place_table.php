<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place', function (Blueprint $table) {
            $table->string('provincia', 45);
            $table->string('municipio', 45);
            $table->integer('codigoProvincia');
            $table->integer('codigoMunicipio');
            $table->integer('poblacion');
            $table->string('imagenMunicipio', 300)->nullable();
            $table->bigInteger('cLatitud')->nullable();
            $table->bigInteger('cLongitud')->nullable();
            $table->boolean('despoblacion')->nullable();
            $table->primary(['provincia', 'municipio']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place');
    }
}
