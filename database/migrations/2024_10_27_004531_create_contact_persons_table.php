<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPersonsTable extends Migration
{
    public function up()
    {
        Schema::create('contact_persons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('position');
            $table->string('office');
            $table->string('telephone_number');
            $table->string('mobile_number');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_persons');
    }
}