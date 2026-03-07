<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'program_id',
    ];
}
