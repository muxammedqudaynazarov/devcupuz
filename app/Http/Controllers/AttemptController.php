<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AttemptController extends Controller
{
    public function login()
    {
        $user = User::find(346241100245);
        Auth::login($user);
    }

    public function checkCode()
    {
        $studentCode = '<?php echo (int)fgets(STDIN) + (int)fgets(STDIN);';
        $languageId = 68;
        $testCases = [
            ['input' => "2\n3", 'expected_output' => "5"],
            ['input' => "10\n20", 'expected_output' => "30"],
            ['input' => "-5\n5", 'expected_output' => "0"],
            ['input' => "0\n0", 'expected_output' => "0"]
        ];
        $submissions = [];
        foreach ($testCases as $test) {
            $submissions[] = [
                'language_id' => $languageId,
                'source_code' => $studentCode,
                'stdin' => $test['input'],
                'expected_output' => $test['expected_output'],
                'cpu_time_limit' => 1.0,
                'memory_limit' => 10000
            ];
        }
        $headers = [
            'x-rapidapi-host' => 'judge0-ce.p.rapidapi.com',
            'x-rapidapi-key' => '250eb2519bmsh63b7804483330d8p140a1bjsnc8a331e398c8',
            'Content-Type' => 'application/json'
        ];

        $postResponse = Http::withHeaders($headers)->post('https://judge0-ce.p.rapidapi.com/submissions/batch?base64_encoded=false', [
            'submissions' => $submissions
        ]);
        $tokensArray = $postResponse->json();
        $tokensList = collect($tokensArray)->pluck('token')->join(',');
        sleep(2);
        $getResult = Http::withHeaders($headers)->get("https://judge0-ce.p.rapidapi.com/submissions/batch?tokens={$tokensList}&base64_encoded=false");
        $results = $getResult->json();
        $passed = 0;
        $total = count($testCases);
        foreach ($results['submissions'] as $res) {
            if ($res['status']['id'] === 3) {
                $passed++;
            }
        }
        return $results;
        return response()->json([
            'total_tests' => $total,
            'passed_tests' => $passed,
            'is_success' => ($passed === $total),
            'details' => $results['submissions'] // Frontendda har bir testni qizil/yashil qilib ko'rsatish uchun
        ]);
    }

    public function checkCode2()
    {
        $studentCode = '<?php echo (int)fgets(STDIN) + (int)fgets(STDIN);'; // A+B masalasi kodi
        $languageId = 68;
        $input = "2\n3";
        $expectedOutput = "5";

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'judge0-ce.p.rapidapi.com',
            'x-rapidapi-key' => '250eb2519bmsh63b7804483330d8p140a1bjsnc8a331e398c8',
            'Content-Type' => 'application/json'
        ])->post('https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=false&wait=true', [
            'source_code' => $studentCode,
            'language_id' => $languageId,
            'stdin' => $input,
            'expected_output' => $expectedOutput,
            'cpu_time_limit' => 1.0,
            'memory_limit' => 32000
        ]);
        $result = $response->json();

        return $result;
    }
}
