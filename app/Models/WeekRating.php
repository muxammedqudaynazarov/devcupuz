<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WeekRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'week_id',
        'penalty',
        'attempts',
        'score',
        'secret',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
