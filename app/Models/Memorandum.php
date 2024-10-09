<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memorandum extends Model
{
    protected $table = 'memorandums';
    // Add the new fields to the fillable array
    protected $fillable = [
        'partner_name',
        'contact_person',  // New field for contact person
        'contact_email',   // New field for contact email
        'whereas_clauses',
        'articles'
    ];

    // Decode the JSON fields automatically when retrieving from the database
    public function getWhereasClausesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getArticlesAttribute($value)
    {
        return json_decode($value, true);
    }

    // Encode the JSON fields automatically when saving to the database
    public function setWhereasClausesAttribute($value)
    {
        $this->attributes['whereas_clauses'] = json_encode($value);
    }

    public function setArticlesAttribute($value)
    {
        $this->attributes['articles'] = json_encode($value);
    }
}
