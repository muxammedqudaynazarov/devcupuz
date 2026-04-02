<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Program;
use App\Models\Submission;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('user.problems.view')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        $user = auth()->user();
        // 1. Foydalanuvchiga tegishli status='1' va active='1' bo'lgan turnirni olish
        $activeTournament = $user->tournaments()->wherePivot('status', '1')
            ->wherePivot('active', '1')->first();

        if (!$activeTournament) {
            return redirect()->route('student.tournaments.index')->with('error', 'Sizda faollashtirilgan turnir mavjud emas.');
        }

        // Barcha haftalarni tartib bilan olish
        $weeks = $activeTournament->weeks()->orderBy('week_number', 'asc')->get();
        $selectedWeekId = $request->get('week');
        $currentWeek = null;
        // 2. Agar foydalanuvchi ma'lum bir haftani tanlagan bo'lsa
        if ($selectedWeekId) {
            $currentWeek = $weeks->where('id', $selectedWeekId)->first();
            if (!$currentWeek) {
                return redirect()->route('problems.index')->with('error', 'So‘ralgan bosqich topilmadi.');
            }
        }
        // 3. Agar hafta tanlanmagan bo'lsa, "finished" vaqti eng yaqin bo'lgan haftani topamiz
        if (!$currentWeek) {
            $currentWeek = $weeks->where('finished', '>=', now())->sortBy('finished')->first();
            // Agar barcha haftalar tugagan bo'lsa, eng oxirgi haftani ko'rsatamiz
            if (!$currentWeek) {
                $currentWeek = $weeks->last();
            }
        }
        // Tanlangan yoki aniqlangan haftadagi masalalarni olish
        if ($currentWeek) {
            $problems = $currentWeek->problems()->withCount([
                // Accepted (Status 2) bo'lgan urinishlar soni
                'submissions as is_solved' => function ($q) use ($user) {
                    $q->where('user_id', $user->id)->where('status', '2');
                },
                // Umuman barcha urinishlar soni
                'submissions as total_attempts' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                }
            ])->get();
        } else {
            // Agar hafta topilmasa, bo'sh kolleksiya qaytaramiz
            $problems = collect();
        }
        return view('student.problems.index', compact(['weeks', 'currentWeek', 'problems', 'activeTournament']));
    }

    public function show($id)
    {
        if (!auth()->user()->can('user.problems.show')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        $user = auth()->user();
        // 1. Masala, hafta va turnirni yuklash
        $problem = Problem::with('week.tournament')->findOrFail($id);
        $week = $problem->week;
        $tournament = $week->tournament;

        // 2. Xavfsizlik: Tur boshlanganligini tekshirish
        if (now()->lessThan($week->started)) {
            return redirect()->route('problems.index')->with('error', 'Kechirasiz, ushbu tur hali boshlanmagan!');
        }

        // 3. Xavfsizlik: Talaba turnirga qabul qilinganligini tekshirish
        $isParticipant = $user->tournaments()->where('tournament_id', $tournament->id)->wherePivot('status', '1')->exists();

        if (!$isParticipant) {
            return redirect()->route('student.tournaments.index')
                ->with('error', 'Siz ushbu turnirda ishtirok etmayapsiz yoki arizangiz tasdiqlanmagan.');
        }

        // 4. Faqat ushbu turnir uchun ruxsat etilgan tillarni olish
        // (Tournament modelida programs() munosabati bor deb hisoblaymiz)
        $programs = $tournament->programs()->where('programs.status', '1')->orderBy('name', 'asc')->get();

        // 5. Talabaning ushbu masala uchun oxirgi 10 ta urinishini olish
        $attempts = Submission::where('user_id', $user->id)->where('problem_id', $problem->id)
            ->latest()->take(10)->get();

        return view('student.problems.show', compact(['problem', 'programs', 'attempts', 'week']));
    }
}
