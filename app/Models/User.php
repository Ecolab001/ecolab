<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'expires_at',
        'code',
        'identity_document',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // 🔗 RELATIONS

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}