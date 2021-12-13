<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePathologyRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathology_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patientId')->unsigned();
            $table->bigInteger('pathologyId')->unsigned();
            $table->timestamps();

            //FK

            $table->foreign('patientId')->references('id')->on('patients')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('pathologyId')->references('id')->on('pathologies')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pathology_records');
    }
}
