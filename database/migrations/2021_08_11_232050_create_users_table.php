<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->string('name');
            $table->bigInteger("post")->unsigned();
            $table->bigInteger("permission")->unsigned();
            $table->bigInteger("type")->unsigned();
            $table->date('birthdate');
            $table->bigInteger('gender')->unsigned();
            $table->bigInteger('address')->unsigned()->nullable();
            $table->bigInteger('patientId')->unsigned()->nullable();
            $table->text('userCpf');
            $table->text('userRg');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            //FK

            $table->foreign("post")->references("id")->on("user_posts")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("permission")->references("id")->on("user_permissions")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("type")->references("id")->on("user_types")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("gender")->references("id")->on("genders")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("address")->references("id")->on("user_addresses")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("patientId")->references("id")->on("patients")->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
