<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdealistainnercardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idealistainnercard', function (Blueprint $table) {
            $table->string('cardLink', 100)->index('pk_fk_cardLink');
            $table->string('innerCardTitle', 45);
            $table->string('innerCardPlace', 45);
            $table->string('innerCardDetail', 300);
            $table->integer('innerCardPrice');
            $table->string('innerCardDescription', 300);
            $table->integer('innerCardContact');
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
        Schema::dropIfExists('idealistainnercard');
    }
}
