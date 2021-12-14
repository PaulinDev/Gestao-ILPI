<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->bigInteger('patientId')->unsigned();
            $table->bigInteger('userId')->unsigned();
            $table->bigInteger('type')->unsigned();
            $table->timestamps();

            //FK's

            $table->foreign('patientId')->references('id')->on('patients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('userId')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('type')->references('id')->on('guardian_types')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guardians');
    }
}
