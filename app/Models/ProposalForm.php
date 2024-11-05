<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalForm extends Model
{
    use HasFactory;
    protected $table = 'proposal_forms';
    // Add the new fields to the fillable array
    protected $fillable = [
        'institution_name',
        'institution_name_acronym',
        'institution_head',
        'institution_head_title',
        'country',
        'type_of_institution',
        'email',
        'telephone_number',
        'mobile_number',
        'website',
        'address',
        'institution_overview',
        'institution_accreditation',
        'target_participant',
        'target_level',
        'institutional_unit_id',
        'type_of_partnership',
        'partnership_overview',
        'partnership_expected_outcome',
        'partnership_target_participants',
        'contact_person_id',
    ];

    protected $casts = [
        'institution_accreditation' => 'array', // Ensure accreditation data is stored as JSON
    ];

    public function institutionalUnit()
    {
        return $this->belongsTo(InstitutionalUnit::class);
    }

    public function contactPerson()
    {
        return $this->belongsTo(ContactPerson::class);
    }

    public function partnerLinkages()
    {
        return $this->hasMany(PartnerLinkage::class);
    }
}
