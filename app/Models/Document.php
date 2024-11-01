<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['memorandum_id', 'endorsement_form_id', 'proposal_form_id', 'institutional_unit_id', 'is_ogr_approved', 'is_downloaded'];

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

    public function approvals()
    {
        return $this->hasMany(DocumentApproval::class);
    }

    public function institutionalUnits()
    {
        return $this->belongsTo(InstitutionalUnit::class, 'institutional_unit_id');
    }
}
