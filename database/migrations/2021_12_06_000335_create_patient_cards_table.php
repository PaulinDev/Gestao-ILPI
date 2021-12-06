<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_cards', function (Blueprint $table) {
            $table->id();
            $table->text('card')->nullable();
            $table->text('contribution')->nullable();
            $table->text('securitySocial')->nullable();
            $table->text('systemHealth')->nullable();
            $table->bigInteger('patient')->unsigned();
            $table->timestamps();

            //FK

            $table->foreign('patient')->references('id')->on('patients')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_cards');
    }
}
