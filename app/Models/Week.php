<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tournament_id',
        'week_number',
        'started',
        'finished',
        'status',
    ];
    protected $casts = [
        'started' => 'datetime',
        'finished' => 'datetime',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function problems(): HasMany
    {
        return $this->hasMany(Problem::class, 'week_id', 'id');
    }
}
