<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class InstitutionalUnit extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'contact_person', 
        'email', 
        'username', 
        'password',
        'must_change_password',
        'mother_affiliate_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function links ()
    {
        return $this->belongsToMany(Link::class, 'institutional_unit_link');
    }

    public function motherAffiliate()
    {
        return $this->belongsTo(Affiliate::class, 'mother_affiliate_id');
    }
}
