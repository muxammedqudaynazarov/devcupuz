<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Week extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'tournament_id',
        'week_number',
        'started',
        'finished',
        'status',
    ];
    public $translatable = ['name'];
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
