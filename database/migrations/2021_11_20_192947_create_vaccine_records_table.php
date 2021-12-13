<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccineRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_records', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->bigInteger('patient')->unsigned();
            $table->bigInteger('vaccine')->unsigned();
            $table->bigInteger('vaccineBrand')->unsigned()->nullable();
            $table->text('batch')->nullable();
            $table->text('comments')->nullable();
            $table->date('date');
            $table->date('returnDate')->nullable();
            $table->timestamps();

            //FK's

            $table->foreign('patient')->on('patients')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('vaccine')->on('vaccines')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('vaccineBrand')->on('vaccine_brands')->references('id')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccine_records');
    }
}
