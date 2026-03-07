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
        $submissions = Submission::with(['user', 'problem', 'program'])->latest()->paginate(5);
        if ($request->ajax()) {
            return response()->json([
                'html' => view('student.submissions._rows', compact('submissions'))->render()
            ]);
        }
        return view('student.submissions.index', compact('submissions'));
    }

    public function checkCode(Request $request)
    {
        $request->validate([
            'problem_id' => 'required|integer|exists:problems,id',
            'program_id' => 'required|integer|exists:programs,id', // 'exists' qoidasi xatolikni oldini oladi
            'code' => 'required|string',
        ]);

        $problem = Problem::findOrFail($request->problem_id);
        $user = auth()->user();

        $testCases = json_decode($problem->example, true) ?? [];

        if (empty($testCases)) {
            return response()->json(['status' => '4', 'message' => 'Masalada test namunalari yo‘q.']);
        }

        // 1-QADAM: Status = 0 (Yuklangan/Navbatda)
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
                'source_code' => $request->code,
                'stdin' => $test['input'],
                'expected_output' => $test['output'],
                'cpu_time_limit' => (float)$problem->runtime,
                'memory_limit' => (int)$problem->memory * 1024,
            ];
        }

        $headers = [
            'x-rapidapi-host' => 'judge0-ce.p.rapidapi.com',
            'x-rapidapi-key' => '250eb2519bmsh63b7804483330d8p140a1bjsnc8a331e398c8',
            'Content-Type' => 'application/json'
        ];

        $postResponse = Http::withHeaders($headers)
            ->post('https://judge0-ce.p.rapidapi.com/submissions/batch?base64_encoded=false', [
                'submissions' => $judgeSubmissions
            ]);

        // Agar Judge0 ishlamasa: Status = 4 (Tizim xatosi)
        if (!$postResponse->successful()) {
            $submission->update([
                'status' => '4',
                'message' => 'Judge0 API bilan aloqa yo‘q.'
            ]);
            return response()->json(['status' => '4', 'message' => 'API Error']);
        }

        $tokensArray = $postResponse->json();
        $tokensList = collect($tokensArray)->pluck('token')->join(',');

        // 2-QADAM: Status = 1 (Tekshirilmoqda)
        $submission->update([
            'token' => $tokensList,
            'status' => '1',
            'message' => 'Testlar tekshirilmoqda...',
        ]);

        $maxAttempts = 10;
        $attempt = 0;
        $results = []; // MUHIM: foreach xato bermasligi uchun bo'sh massiv bilan boshlaymiz
        $isFinished = false;

        while ($attempt < $maxAttempts) {
            sleep(1.5);

            // MUHIM YECHIM: URL oxiriga `&fields=time,memory,status` qo'shildi.
            // Bu orqali katta va noto'g'ri belgilar bilan keladigan compile_output matnidan qutulamiz.
            $getResult = Http::withHeaders($headers)
                ->get("https://judge0-ce.p.rapidapi.com/submissions/batch?tokens={$tokensList}&base64_encoded=false&fields=time,memory,status");

            if ($getResult->successful()) {
                $responseJson = $getResult->json();

                // Agar API to'g'ri ishlab submissions qaytarsa
                if (isset($responseJson['submissions'])) {
                    $results = $responseJson['submissions'];

                    $isFinished = true;
                    foreach ($results as $res) {
                        if (isset($res['status']['id']) && in_array($res['status']['id'], [1, 2])) {
                            $isFinished = false; // Hali tugamagan test bor
                            break;
                        }
                    }

                    if ($isFinished) {
                        break; // Barchasi 1 yoki 2 dan chiqdi
                    }
                }
            }
            $attempt++;
        }

        // XAVFSIZLIK TEKSHIRUVI: Agar tsikl tugasa lekin results haliyam bo'sh bo'lsa (Dastur qotishini oldini oladi)
        if (!$isFinished || empty($results)) {
            $submission->update([
                'status' => '3',
                'message' => 'Kompilyatsiya xatosi (Yoki noto\'g\'ri format)',
            ]);
            return response()->json([
                'submission_id' => $submission->id,
                'uuid' => $submission->uuid,
                'status' => '3',
                'message' => 'Kompilyatsiya xatosi',
                'time' => 0,
                'memory' => 0,
                'passed' => 0,
                'total' => count($testCases),
            ]);
        }

        // 3-QADAM: Natijalarni tahlil qilish
        $overallStatus = '2'; // Default: 2 (Accepted)
        $overallMessage = 'Accepted';
        $maxTime = 0;
        $maxMemory = 0;
        $passed = 0;
        $total = count($testCases);

        // Foreach siklida indeksni ham kuzatamiz
        foreach ($results as $index => $res) {
            $time = (float)($res['time'] ?? 0);
            $memory = (int)($res['memory'] ?? 0);

            if ($time > $maxTime) $maxTime = $time;
            if ($memory > $maxMemory) $maxMemory = $memory;

            // Agar status 3 (Accepted) bo'lmasa, demak xatolik bor
            if (isset($res['status']['id']) && $res['status']['id'] !== 3) {
                // Agar hali umumiy status o'zgarmagan bo'lsa, birinchi topilgan xatoni qayd etamiz
                if ($overallStatus === '2') {
                    $overallStatus = '3'; // 3: Error
                    $testNumber = $index + 1; // Test raqami 1 dan boshlanishi uchun
                    $overallMessage = $res['status']['description'] . ' #' . $testNumber;
                }
            } else {
                $passed++;
            }
        }

        $maxMemoryMB = round($maxMemory / 1024, 2);

        // 4-QADAM: Yakuniy holatni bazaga yozish
        $submission->update([
            'status' => $overallStatus,
            'message' => $overallMessage,
            'time' => $maxTime,
            'memory' => $maxMemoryMB,
        ]);

        // 5-QADAM: REYTINGNI HISOBLASH (Faqat Accepted bo'lsa)
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
            'passed' => $passed,
            'total' => $total,
        ]);
    }

    private function updateUserRating($submission, $problem, $user)
    {
        // 1. Ushbu masalani foydalanuvchi avval muvaffaqiyatli yechganmi?
        $alreadySolved = Submission::where('user_id', $user->id)->where('problem_id', $problem->id)
            ->where('status', '2')->where('id', '!=', $submission->id)->exists();

        // Agar avval yechilgan bo'lsa, reyting o'zgarmaydi
        if ($alreadySolved) return;

        // 2. Masala tegishli bo'lgan turnirni topish
        // Masala -> Hafta (Week) -> Turnir (Tournament)
        $tournament = $problem->week->tournament;
        if (!$tournament) return;

        // 3. Ushbu masalani yechguncha qancha urinish bo'lganini aniqlash
        $attemptsCount = Submission::where('user_id', $user->id)->where('problem_id', $problem->id)
            ->where('id', '<=', $submission->id)->count();

        // 4. Penaltini hisoblash (Turnir boshlanganidan masalani yechguncha o'tgan daqiqalar)
        $startTime = $tournament->started; // Turnir boshlanish vaqti
        $solvedTime = $submission->created_at; // Masala yechilgan vaqt

        $penaltyMinutes = $solvedTime->diffInMinutes($startTime);

        // 5. Rating jadvalini yangilash
        // updateOrCreate - agar user va tournament uchun qator bo'lsa yangilaydi, bo'lmasa ochadi
        $rating = Rating::firstOrNew([
            'user_id' => $user->id,
            'tournament_id' => $tournament->id,
        ]);

        // Qiymatlarni umumiy yig'ib borish
        $rating->score = ($rating->score ?? 0) + $problem->point; // Masala ballini qo'shish
        $rating->attempts = ($rating->attempts ?? 0) + $attemptsCount; // Urinishlarni qo'shish
        $rating->penalty = ($rating->penalty ?? 0) + $penaltyMinutes; // Penaltini qo'shish
        $rating->save();
    }
}
