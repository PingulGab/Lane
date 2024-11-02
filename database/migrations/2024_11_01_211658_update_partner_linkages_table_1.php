<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partner_linkages', function (Blueprint $table) {
            $table->foreignId('proposal_form_id')->constrained('proposal_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner_linkages', function (Blueprint $table) {
            $table->dropColumn('proposal_form_id'); // Remove the column if rolling back
        });
    }
};
