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
        'whereas_clauses',
        'articles',
        'version',
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
