<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalFormTable extends Migration
{
    public function up()
    {
        Schema::create('proposal_forms', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('institution_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposal_forms');
    }
}