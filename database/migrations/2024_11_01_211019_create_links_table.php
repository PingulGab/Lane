<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link')->unique();
            $table->string('password');
            $table->boolean('isActive')->default(true);
            $table->foreignId('memorandum_fk')->nullable()->constrained('memorandums')->onDelete('cascade');
            $table->foreignId('proposal_form_fk')->nullable()->constrained('proposal_forms')->onDelete('cascade');
            $table->foreignId('endorsement_form_fk')->nullable()->constrained('endorsement_forms')->onDelete('cascade');
            $table->foreignId('institutional_unit_id')->nullable()->constrained('institutional_units')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('links');
    }
}