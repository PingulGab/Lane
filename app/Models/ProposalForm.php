<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalForm extends Model
{
    protected $table = 'proposal_form';
    // Add the new fields to the fillable array
    protected $fillable = [
        'institution_name',
        'country'
    ];
}