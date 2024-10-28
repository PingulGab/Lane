<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Affiliate extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'contact_person', 
        'email', 
        'username', 
        'password',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
    ];

    public function links ()
    {
        return $this->belongsToMany(Link::class, 'affiliate_link');
    }
}
