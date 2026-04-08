<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'center_id',
        'name',
        'description',
        'capacity',
    ];

    // 🔗 RELATIONS

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}