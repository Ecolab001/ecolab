<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'image',
        'status',
        'is_visible',
    ];

    // 🔗 RELATIONS

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}