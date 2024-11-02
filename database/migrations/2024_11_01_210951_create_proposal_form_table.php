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
            $table->string('institution_name');
            $table->string('country');
            $table->enum('type_of_institution', ['Private Higher Educational Institution', 'Public Higher Educational Institution', 'Private Company', 'Public Company', 'Organization', 'Government Agency']);
            $table->string('email');
            $table->string('telephone_number');
            $table->string('mobile_number');
            $table->string('website');
            $table->string('institution_overview');
            $table->json('institution_accreditation');

            $table->enum('target_participant', ['Student', 'Faculty', 'Researcher']);
            $table->enum('target_level', ['Elementary', 'Junior High School', 'Senior High School', 'Undergraduate', 'Graduate School', 'Certification Program (ESL)']);
            
            //Foreign Key to Institutional Unit
            $table->foreignId('institutional_unit_id')->constrained('institutional_units')->onDelete('cascade');

            $table->string('type_of_partnership');
            $table->string('partnership_overview');
            $table->string('partnership_expected_outcome');
            $table->string('partnership_target_participants');

            //Foreign Key to Contact Person
            $table->foreignId('contact_person_id')->constrained('contact_persons')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposal_forms');
    }
}