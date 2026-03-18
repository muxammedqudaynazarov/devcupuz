<?php

namespace App\Models;

use App\Models\System\University;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Tournament extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'id',
        'name',
        'desc',
        'started',
        'finished',
        'deadline',
        'status',
    ];

    public $translatable = ['desc'];

    protected $casts = [
        'started' => 'datetime',
        'finished' => 'datetime',
        'deadline' => 'datetime',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'tournament_programs');
    }

    public function universities()
    {
        return $this->belongsToMany(University::class, 'tournament_universities');
    }

    public function weeks()
    {
        return $this->hasMany(Week::class, 'tournament_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tournament_users');
    }
}
