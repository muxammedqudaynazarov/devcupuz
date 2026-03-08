<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\HasTranslations;

class Problem extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'id',
        'name',
        'desc',
        'user_id',
        'week_id',
        'input_text',
        'output_text',
        'example',
        'memory',
        'runtime',
        'point',
    ];

    public $translatable = ['name', 'desc', 'input_text', 'output_text'];

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class, 'problem_id', 'id');
    }

    public function week(): HasOne
    {
        return $this->hasOne(Week::class, 'id', 'week_id');
    }
}
