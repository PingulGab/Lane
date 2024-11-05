<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EndorsementForm extends Model
{
    protected $table = 'endorsement_forms';
    // Add the new fields to the fillable array
    protected $fillable = [
        'endorsement_1.1',
        'endorsement_1.2',
        'endorsement_1.3',
        'endorsement_1.4',
        'endorsement_1.5',
        'endorsement_1.6',
        'endorsement_1.7',
        'endorsement_1.8',
    ];
}
