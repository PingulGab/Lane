<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Affiliate extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'affiliate_name', 
        'affiliate_contact_person', 
        'affiliate_email', 
        'username', 
        'password',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
    ];

    // Ensure password is hashed
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
