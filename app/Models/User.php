<?php

namespace App\Models;

use App\Models\System\University;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'id',
        'name',
        'username',
        'password',
        'phone',
        'pos',
        'rol',
        'image',
        'university_id',
        'status',
        'theme',
        'per_page',
        'language',
    ];

    protected $casts = [
        'name' => 'array',
        'rol' => 'array',
    ];

    public function medals()
    {
        return $this->belongsToMany(Medal::class, 'user_medals')->withTimestamps();
    }

    public function university(): HasOne
    {
        return $this->hasOne(University::class, 'id', 'university_id');
    }

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'tournament_users');
    }
}
