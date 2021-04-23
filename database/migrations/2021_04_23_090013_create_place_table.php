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
            $table->string('imagenMuncipio', 300);
            $table->double('cAltitud');
            $table->double('cLongitud');
            $table->tinyInteger('despoblacion');
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
