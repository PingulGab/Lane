<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemorandumsTable extends Migration
{
    public function up()
    {
        Schema::create('memorandums', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name');
            $table->json('whereas_clauses')->nullable();
            $table->json('articles')->nullable();
            $table->string('contact_person')->nullable(); // Add contact person field
            $table->string('contact_email')->nullable();  // Add contact email field
            $table->unsignedBigInteger('locked_by')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->decimal('version', 3, 1)->default(1.0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('memorandums');
    }
}
