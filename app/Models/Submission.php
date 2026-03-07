<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem_id',
        'user_id',
        'program_id',
        'uuid',
        'code',
        'time',
        'memory',
        'token',
        'message',
        'status',
    ];

    public function problem()
    {
        return $this->belongsTo(Problem::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function program(): HasOne
    {
        return $this->hasOne(Program::class, 'id', 'program_id');
    }
}
