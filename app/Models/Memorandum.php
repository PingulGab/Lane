<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memorandum extends Model
{
    protected $table = 'memorandums';
    // Add the new fields to the fillable array
    protected $fillable = [
        'partnership_title',
        'validity_period',
        'sign_date',
        'sign_location',
        'whereas_clauses',
        'article_1',
        'article_2_AUF',
        'article_2_partner',
        'article_3',
        'article_4',
        'article_5',
        'article_6',
        'article_7',
        'article_8',
        'article_9',
        'article_10',
        'article_11',
        'article_12',
        'article_13',
        'article_14',
        'article_15',
        'article_16',
        'article_17',
        'article_18',
        'article_19',
        'article_20',
        'article_21',

        'valid_until',
        'locked_by',
        'locked_at',
        'version',
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

    public function versions()
    {
        return $this->hasMany(MemorandumVersion::class);
    }
}
