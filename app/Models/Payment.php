<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

  protected $fillable = [
    'user_id',
    'candidate_id',
    'type',
    'amount',
    'transaction_id',
    'feexpay_reference', // 🔥 AJOUT CRITIQUE
    'status',
];

    protected $casts = [
        'amount' => 'integer',
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