<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'password', 
        'birth_date',
        'profile_picture',
        'is_self_pay',
        'address',
        'phone_number'
    ];

    protected $hidden = [
        'password'
    ];

    // Mutator to hash password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}