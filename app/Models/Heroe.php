<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class Heroe extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'user_id', 'week_id', 'points', 'image', 'desc'
    ];

    public $translatable = ['desc'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function week(): HasOne
    {
        return $this->hasOne(Week::class, 'id', 'week_id');
    }
}
