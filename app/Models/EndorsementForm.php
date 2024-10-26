<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EndorsementForm extends Model
{
    protected $table = 'endorsement_forms';
    // Add the new fields to the fillable array
    protected $fillable = [
        'Description_1',
        'Description_2'
    ];
}
