<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionalUnitTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('institutional_units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_person');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('must_change_password')->default(true); // Force password change
            $table->foreignId('mother_affiliate_id')->constrained('affiliates')->onDelete('cascade');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('institutional_units');
    }
};
