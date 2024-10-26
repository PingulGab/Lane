<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndorsementFormTable extends Migration
{
    public function up()
    {
        Schema::create('endorsement_forms', function (Blueprint $table) {
            $table->id();
            $table->text('description_1');
            $table->text('description_2');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('endorsement_forms');
    }
}