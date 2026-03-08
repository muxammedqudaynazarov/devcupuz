<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Medal extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'desc'];

    protected $fillable = [
        'name',
        'desc',
        'type',
        'requirement',
        'color_class',
        'image',
    ];
}
