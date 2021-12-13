<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patientId')->unsigned();
            $table->text('title');
            $table->date('dateAppointment');
            $table->time('startAppointment');
            $table->time('endAppointment')->nullable();
            $table->text('additional')->nullable();
            $table->boolean('internal')->nullable();
            $table->timestamps();

            //FK

            $table->foreign('patientId')->references('id')->on('patients')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
