<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;
    protected $table = 'contact_persons';
    protected $fillable = [
        'name',
        'email',
        'position',
        'office',
        'telephone_number',
        'mobile_number',
    ];

    public function proposalForms()
    {
        return $this->hasMany(ProposalForm::class);
    }

}
