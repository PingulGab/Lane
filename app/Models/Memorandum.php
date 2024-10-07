<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memorandum extends Model
{
    protected $table = 'memorandums'; // Specify the table name

    protected $fillable = ['partner_name', 'whereas_clauses', 'articles'];

    // Accessor to automatically decode JSON to array for whereas_clauses
    public function getWhereasClausesAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    // Accessor to automatically decode JSON to array for articles
    public function getArticlesAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    // Mutator to encode whereas_clauses as JSON when setting
    public function setWhereasClausesAttribute($value)
    {
        $this->attributes['whereas_clauses'] = json_encode($value);
    }

    // Mutator to encode articles as JSON when setting
    public function setArticlesAttribute($value)
    {
        $this->attributes['articles'] = json_encode($value);
    }
}