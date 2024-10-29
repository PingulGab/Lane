<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentApproval extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'affiliate_id', 'is_approved', 'approved_at', 'comments'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}
