<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $response = Http::get('https://ce.judge0.com/languages');
        $programs = $response->json();
        foreach ($programs as $program) {
            Program::create([
                'id' => $program['id'],
                'name' => $program['name'],
            ]);
        }
    }
}
