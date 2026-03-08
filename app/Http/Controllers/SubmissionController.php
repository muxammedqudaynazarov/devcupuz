<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Submission;
use App\Models\Problem;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submissions = Submission::with(['user', 'problem', 'program'])->latest()->paginate(auth()->user()->per_page);
        if ($request->ajax()) {
            return response()->json([
                'html' => view('student.submissions._rows', compact(['submissions']))->render()
            ]);
        }
        return view('student.submissions.index', compact(['submissions']));
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'problem_id' => 'required|integer|exists:problems,id',
            'program_id' => 'required|integer|exists:programs,id',
            'code' => 'required|string',
        ]);

        $problem = Problem::findOrFail($request->problem_id);
        $user = auth()->user();
        $testCases = json_decode($problem->example, true) ?? [];

        if (empty($testCases)) {
            return response()->json(['status' => '4', 'message' => 'Masalada test namunalari yo‘q.']);
        }

        $submission = Submission::create([
            'problem_id' => $problem->id,
            'user_id' => $user->id,
            'program_id' => $request->program_id,
            'uuid' => uniqid(),
            'code' => $request->code,
            'status' => '0',
            'time' => 0,
            'memory' => 0,
            'token' => '',
            'message' => 'Navbatda kutmoqda...',
        ]);

        $judgeSubmissions = [];
        foreach ($testCases as $test) {
            $judgeSubmissions[] = [
                'language_id' => $request->program_id,
                'source_code' => base64_encode($request->code),
                'stdin' => base64_encode($test['input']),
                'expected_output' => base64_encode(str_replace("\r\n", "\n", trim($test['output']))),
                'cpu_time_limit' => (float)$problem->runtime,
                'memory_limit' => (int)$problem->memory * 1024,
            ];
        }

        $headers = [
            'x-rapidapi-host' => 'judge0-ce.p.rapidapi.com',
            'x-rapidapi-key' => env('RAPID_API_KEY'),
            'Content-Type' => 'application/json'
        ];

        // base64_encoded=true qilib o'zgartirildi
        $postResponse = Http::withHeaders($headers)
            ->post('https://judge0-ce.p.rapidapi.com/submissions/batch?base64_encoded=true', [
                'submissions' => $judgeSubmissions
            ]);

        if (!$postResponse->successful()) {
            $submission->update(['status' => '4', 'message' => 'Judge0 API bilan aloqa yo‘q.']);
            return response()->json(['status' => '4', 'message' => 'API Error']);
        }

        $tokensArray = $postResponse->json();
        $tokensList = collect($tokensArray)->pluck('token')->join(',');

        $submission->update([
            'token' => $tokensList,
            'status' => '1',
            'message' => 'Testlar tekshirilmoqda...',
        ]);

        $maxAttempts = 15; // Vaqtni biroz uzaytirdik
        $results = [];
        $isFinished = false;

        for ($i = 0; $i < $maxAttempts; $i++) {
            sleep(2);
            $getResult = Http::withHeaders($headers)
                ->get("https://judge0-ce.p.rapidapi.com/submissions/batch?tokens={$tokensList}&base64_encoded=true&fields=time,memory,status,stdout,stderr");

            if ($getResult->successful()) {
                $responseJson = $getResult->json();
                if (isset($responseJson['submissions'])) {
                    $results = $responseJson['submissions'];
                    $isFinished = !collect($results)->contains(fn($res) => in_array($res['status']['id'], [1, 2]));
                    if ($isFinished) break;
                }
            }
        }

        if (!$isFinished || empty($results)) {
            $submission->update(['status' => '3', 'message' => 'Tekshirish vaqti tugadi yoki xatolik.']);
            return response()->json(['status' => '3', 'message' => 'Timeout Error']);
        }

        $overallStatus = '2';
        $overallMessage = 'Accepted';
        $maxTime = 0;
        $maxMemory = 0;
        $passedCount = 0;

        foreach ($results as $index => $res) {
            $maxTime = max($maxTime, (float)($res['time'] ?? 0));
            $maxMemory = max($maxMemory, (int)($res['memory'] ?? 0));

            // Status 3 - Accepted degani
            if (isset($res['status']['id']) && $res['status']['id'] !== 3) {
                if ($overallStatus === '2') {
                    $overallStatus = '3';
                    $overallMessage = $res['status']['description'] . ' #' . ($index + 1);
                }
            } else {
                $passedCount++;
            }
        }

        $maxMemoryMB = round($maxMemory / 1024, 2);
        $submission->update([
            'status' => $overallStatus,
            'message' => $overallMessage,
            'time' => $maxTime,
            'memory' => $maxMemoryMB,
        ]);

        // Reytingni yangilash mantiqi
        if ($overallStatus == '2') {
            $this->updateUserRating($submission, $problem, $user);
        }

        return response()->json([
            'submission_id' => $submission->id,
            'status' => $overallStatus,
            'uuid' => $submission->uuid,
            'message' => $overallMessage,
            'time' => $maxTime,
            'memory' => $maxMemoryMB,
            'passed' => $passedCount,
            'total' => count($testCases),
        ]);
    }

    protected function updateUserRating($submission, $problem, $user)
    {
        // Foydalanuvchi joriy turnirda qatnashayotganini aniqlash
        $activeTournament = \DB::table('tournament_users')
            ->where('user_id', $user->id)
            ->where('active', '1')
            ->where('status', '1')
            ->first();

        if (!$activeTournament) return;

        // Ushbu masala uchun avval Accepted bo'lganmi?
        // Agar bo'lgan bo'lsa, ball va urinishlar qayta hisoblanmaydi.
        $alreadySolved = Submission::where('user_id', $user->id)
            ->where('problem_id', $problem->id)
            ->where('status', '2') // 2 - Accepted
            ->where('id', '!=', $submission->id)
            ->exists();

        if ($alreadySolved) return;
        $failedAttempts = Submission::where('user_id', $user->id)
            ->where('problem_id', $problem->id)
            ->where('id', '<', $submission->id)
            ->count();

        $rating = Rating::firstOrCreate(
            ['user_id' => $user->id, 'tournament_id' => $activeTournament->tournament_id],
            ['score' => 0, 'penalty' => 0, 'attempts' => 0]
        );

        $penaltyForErrors = $failedAttempts * 10;
        $rating->increment('score', $problem->point);
        $rating->increment('attempts', $failedAttempts + 1);
        $rating->increment('penalty', $penaltyForErrors);
    }
}
