<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerLinkage extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_name',
        'nature_of_partnership',
        'validity_period',
        'proposal_form_id',
    ];

    public function proposalForm()
    {
        return $this->belongsTo(ProposalForm::class);
    }
}
