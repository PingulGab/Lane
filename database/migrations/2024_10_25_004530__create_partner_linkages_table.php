<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerLinkagesTable extends Migration
{
    public function up()
    {
        Schema::create('partner_linkages', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->string('nature_of_partnership');
            $table->date('validity_period');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('partner_linkages');
    }
}