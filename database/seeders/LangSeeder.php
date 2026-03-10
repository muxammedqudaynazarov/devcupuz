<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    public function run(): void
    {
        Language::create([
            'name' => 'O‘zbekcha',
            'locale' => 'uz',
            'status' => '1',
        ]);
        Language::create([
            'name' => 'Qaraqalpaqsha',
            'locale' => 'kaa',
            'status' => '1',
        ]);
        Language::create([
            'name' => 'Русский',
            'locale' => 'ru',
            'status' => '1',
        ]);
    }
}
