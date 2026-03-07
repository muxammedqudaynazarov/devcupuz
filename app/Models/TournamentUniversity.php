<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentUniversity extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'university_id',
        'user_id',
    ];
}
