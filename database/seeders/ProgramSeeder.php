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

        if ($response->successful()) {
            $programs = $response->json();

            foreach ($programs as $program) {
                Program::updateOrCreate(
                    ['id' => $program['id']],
                    [
                        'name' => $program['name'],
                        'code' => $this->getEditorMode($program['name']), // Aqlli guruhlash
                        'status' => '1',
                    ]
                );
            }
        }
    }

    /**
     * Til nomiga qarab CodeMirror sintaksis rejimini aniqlaydi
     */
    private function getEditorMode(string $name): string
    {
        $name = strtolower($name);

        if (str_contains($name, 'python')) return 'text/x-python';
        if (str_contains($name, 'c++') || str_contains($name, 'cpp')) return 'text/x-c++src';
        if (str_contains($name, 'c#') || str_contains($name, 'csharp')) return 'text/x-csharp';

        // C tili uchun (C++ yoki C# bilan adashib ketmasligi uchun regex ishlatamiz)
        if (preg_match('/^c\s*\(/', $name)) return 'text/x-csrc';

        if (str_contains($name, 'java') && !str_contains($name, 'javascript')) return 'text/x-java';
        if (str_contains($name, 'javascript') || str_contains($name, 'node')) return 'text/javascript';
        if (str_contains($name, 'kotlin')) return 'text/x-kotlin';
        if (str_contains($name, 'php')) return 'text/x-php';
        if (str_contains($name, 'ruby')) return 'text/x-ruby';
        if (str_contains($name, 'rust')) return 'text/x-rustsrc';
        if (str_contains($name, 'go ') || preg_match('/^go\s*\(/', $name)) return 'text/x-go';
        if (str_contains($name, 'sql')) return 'text/x-sql';
        if (str_contains($name, 'typescript')) return 'text/typescript';
        if (str_contains($name, 'swift')) return 'text/x-swift';
        if (str_contains($name, 'scala')) return 'text/x-scala';
        if (str_contains($name, 'bash')) return 'text/x-sh';
        if (str_contains($name, 'assembly')) return 'text/x-gas';

        return 'text/plain'; // Hech biriga tushmasa, oddiy matn rejimi
    }
}
