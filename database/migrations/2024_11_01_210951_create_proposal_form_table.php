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
            $table->string('institution_name_acronym');
            $table->string('institution_head');
            $table->string('institution_head_title');
            $table->string('country');
            $table->enum('type_of_institution', ['Private Higher Educational Institution', 'Public Higher Educational Institution', 'Private Company', 'Public Company', 'Organization', 'Government Agency']);
            $table->string('email');
            $table->string('telephone_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('website')->nullable();
            $table->string('address');
            $table->longText('institution_overview');
            $table->json('institution_accreditation')->nullable();

            $table->enum('target_participant', ['Student', 'Faculty', 'Researcher']);
            $table->enum('target_level', ['Elementary', 'Junior High School', 'Senior High School', 'Undergraduate', 'Graduate School', 'Certification Program (ESL)']);
            
            //Foreign Key to Institutional Unit
            $table->foreignId('institutional_unit_id')->constrained('institutional_units')->onDelete('cascade');

            $table->string('type_of_partnership');
            $table->longText('partnership_overview');
            $table->longText('partnership_expected_outcome');
            $table->longText('partnership_target_participants');

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