<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemorandumVersionsTable extends Migration
{
    public function up()
    {
        Schema::create('memorandum_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorandum_id')->constrained('memorandums')->onDelete('cascade');
            $table->unsignedBigInteger('edited_by');       // The user who made the edit
            $table->json('whereas_clauses')->nullable();   // JSON content at this version
            $table->json('articles')->nullable();
            $table->decimal('version', 3, 1);              // Version number
            $table->timestamps();                          // Timestamps for the version
        });
    }

    public function down()
    {
        Schema::dropIfExists('memorandum_versions');
    }
}
