<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memorandum_id')->nullable()->constrained('memorandums')->onDelete('set null');
            $table->foreignId('endorsement_form_id')->nullable()->constrained('endorsement_forms')->onDelete('set null');
            $table->foreignId('proposal_form_id')->nullable()->constrained('proposal_forms')->onDelete('set null');
            $table->foreignId('institutional_unit_id')->constrained('institutional_units')->onDelete('cascade'); // Added institutional_unit_id
            $table->boolean('is_ogr_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
