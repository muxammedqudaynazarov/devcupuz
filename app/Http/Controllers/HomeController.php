<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Rating;
use App\Models\Submission;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        // 1. Dastlabki bo'sh o'zgaruvchilar (Agar turnir bo'lmasa, xato bermasligi uchun)
        $activeTournament = null;
        $nextWeek = null;
        $topUsers = collect();

        $position = 0;
        $positions = 0;
        $points = 0;
        $problems = 0;
        $coefficient = 0;

        // 2. Foydalanuvchining faol turnirini topish (pivot jadval orqali)
        $activeApp = DB::table('tournament_users')
            ->where('user_id', $user->id)
            ->where('status', '1') // Qabul qilingan
            ->where('active', '1') // Hozirda shu turnirga kirgan (aktiv)
            ->first();

        if ($activeApp) {
            $activeTournament = Tournament::find($activeApp->tournament_id);

            if ($activeTournament) {
                // 3. COUNTDOWN UCHUN: Kelayotgan navbatdagi turni topish
                $nextWeek = $activeTournament->weeks()
                    ->where('started', '>', now())
                    ->orderBy('started', 'asc')
                    ->first();

                // 4. REYTING UCHUN: Top 5 foydalanuvchini olish (Blade shartiga moslab)
                // Tartib: Score (kamayish), Attempts (o'sish), Penalty (o'sish)
                $topUsers = Rating::with('user.university')
                    ->where('tournament_id', $activeTournament->id)
                    ->orderBy('score', 'desc')
                    ->orderBy('attempts', 'asc')
                    ->orderBy('penalty', 'asc')
                    ->take(5)
                    ->get();

                // 5. WIDGETLAR UCHUN: Talabaning pozitsiyasi va umumiy ishtirokchilar soni
                $allRatings = Rating::where('tournament_id', $activeTournament->id)
                    ->orderBy('score', 'desc')
                    ->orderBy('penalty', 'asc')
                    ->orderBy('attempts', 'asc')
                    ->pluck('user_id');

                $posIndex = $allRatings->search($user->id);
                $position = $posIndex !== false ? $posIndex + 1 : 0;
                $positions = $allRatings->count();

                // Talabaning joriy balli (Score)
                $studentRating = Rating::where('tournament_id', $activeTournament->id)
                    ->where('user_id', $user->id)
                    ->first();
                $points = $studentRating ? $studentRating->score : 0;

                // 6. WIDGETLAR UCHUN: Muvaffaqiyatli masalalar va Aniqlilik (Coefficient)
                // Faqatgina ushbu turnirga tegishli masalalardagi urinishlarni olamiz
                $submissions = Submission::where('user_id', $user->id)
                    ->whereHas('problem.week', function($q) use ($activeTournament) {
                        $q->where('tournament_id', $activeTournament->id);
                    })->get();

                $totalAttempts = $submissions->count();
                $acceptedSubmissions = $submissions->where('status', '2'); // 2 - Accepted

                // Nechta *noyob* (unique) masala to'g'ri ishlanganini sanash
                $problems = $acceptedSubmissions->unique('problem_id')->count();

                // Aniqlilik foizi: (To'g'ri javoblar / Barcha urinishlar) * 100
                if ($totalAttempts > 0) {
                    $coefficient = round(($acceptedSubmissions->count() / $totalAttempts) * 100, 1);
                }
            }
        }

        // Barcha ma'lumotlarni Blade faylga yuborish
        return view('student.home', compact(
            'activeTournament',
            'nextWeek',
            'topUsers',
            'position',
            'positions',
            'points',
            'problems',
            'coefficient'
        ));
    }

    public function switch_role($role)
    {
        $user = Auth::user();
        $rols = $user->hemis_roles;
        if (is_string($rols)) {
            $rols = json_decode($rols, true);
        }
        if (!is_array($rols)) {
            $rols = [];
        }
        if (in_array($role, $rols)) {
            $user->removeRole($user->current_role);
            $user->current_role = $role;
            $user->assignRole($role);
            $user->save();
            return redirect(route('home'))->with('success', 'Rol o‘zgartirildi');
        }
        return redirect(route('home'))->with('error', 'Sizda bu rol mavjud emas!');
    }
}
