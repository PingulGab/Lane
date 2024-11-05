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
            $table->longText('endorsement_1_1');
            $table->longText('endorsement_1_2');
            $table->longText('endorsement_1_3');
            $table->longText('endorsement_1_4');
            $table->longText('endorsement_1_5');
            $table->longText('endorsement_1_6');
            $table->longText('endorsement_1_7');
            $table->longText('endorsement_1_8');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('endorsement_forms');
    }
}