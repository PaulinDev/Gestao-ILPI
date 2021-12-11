<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_inventories', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('quantity');
            $table->date('expirationDate');
            $table->date('manufacturingDate')->nullable();
            $table->bigInteger('patientId')->unsigned()->nullable();
            $table->bigInteger('userId')->unsigned()->nullable();
            $table->bigInteger('type')->unsigned();
            $table->timestamps();

            //FK's

            $table->foreign('patientId')->references('id')->on('patients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('userId')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('type')->references('id')->on('inventory_types')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_inventories');
    }
}
