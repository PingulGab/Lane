<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    protected $table = 'partnerships';

    protected $fillable = [
        'partnership_title',
        'memorandum_id',
        'endorsement_form_id',
        'proposal_form_id',
        'institutional_unit_id',
    ];

    public function memorandum()
    {
        return $this->belongsTo(Memorandum::class);
    }

    public function endorsementForm()
    {
        return $this->belongsTo(EndorsementForm::class);
    }

    public function proposalForm()
    {
        return $this->belongsTo(ProposalForm::class);
    }

    public function institutionalUnits()
    {
        return $this->belongsTo(InstitutionalUnit::class, 'institutional_unit_id');
    }
}
