<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'candidate_id',
        'amount',
        'status',
        'paid_at',
        'payment_reference',
        'payment_method',
        'payment_note',
    ];

    protected $casts = [
    'paid_at' => 'datetime',
    ];
    
    // 🔗 RELATIONS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}