<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'logo',
        'client_id',
        'client_secret',
        'hemis_url',
        'hemis_student_url',
        'status',
        'activated_to'
    ];
}
