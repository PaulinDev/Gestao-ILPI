<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_addresses', function (Blueprint $table) {
            $table->id();
            $table->text('address')->nullable();
            $table->text('cep')->nullable();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->bigInteger('patient')->unsigned();
            $table->timestamps();

            //FK

            $table->foreign('patient')->references('id')->on('patients')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_addresses');
    }
}
