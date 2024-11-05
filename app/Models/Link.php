<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',      // The title/name for the link
        'link',      // The generated random link
        'password',  // The hashed password for the link
        'isActive',    // Indicates if the link is active or deleted
        'memorandum_fk',
        'proposal_form_fk',
        'endorsement_form_fk',
    ];

    public function memorandum()
    {
        return $this->belongsTo(Memorandum::class, 'memorandum_fk');
    }

    public function proposalForm()
    {
        return $this->belongsTo(ProposalForm::class, 'proposal_form_fk');
    }

    public function endorsementForm()
    {
        return $this->belongsTo(EndorsementForm::class, 'endorsement_form_fk');
    }

    public function institutionalUnits()
    {
        return $this->belongsToMany(InstitutionalUnit::class, 'institutional_unit_link');
    }

    public function singleInstitutionalUnit()
    {
        return $this->belongsTo(InstitutionalUnit::class, 'institutional_unit_id');
    }

    public function affiliates()
    {
        return $this->belongsToMany(Affiliate::class, 'affiliate_link');
    }

    // You can also define default attributes if needed, for example:
    protected $attributes = [
        'isActive' => true,
    ];
}
