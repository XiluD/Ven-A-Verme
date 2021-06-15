<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsmedicalcentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schoolsmedicalcenters', function (Blueprint $table) {
            $table->string('nombreCentro', 45);
            $table->string('direccion', 100);
            $table->string('provincia', 45);
            $table->string('municipio', 45);
            $table->string('telefono', 20)->nullable();
            $table->index(['provincia', 'municipio'], 'fk_prov_mun');
            $table->primary(['nombreCentro', 'direccion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schoolsmedicalcenters');
    }
}
