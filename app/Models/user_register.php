<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_register extends Model
{
    use HasFactory;
    protected $table = 'user_register';
    protected $primaryKey = 'user_register_id';
    public $incrementing = true;

    protected $fillable = [
        'user_register_name',
        'user_register_email',
        'user_register_password',
        'user_register_phone',
        'user_register_address',
        'user_register_type',
        'user_register_otp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_register_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
