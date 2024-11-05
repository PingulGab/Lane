<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemorandumVersion extends Model
{
    protected $table = 'memorandum_versions';
    // Add the new fields to the fillable array
    protected $fillable = [
        'memorandum_id',
        'edited_by',
        'version',
        'partnership_title',
        'validity_period',
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
    ];

    public function memorandum()
    {
        return $this->belongsTo(Memorandum::class);
    }

    public function editor()
    {
        return $this->belongsTo(Affiliate::class, 'edited_by');
    }
}
