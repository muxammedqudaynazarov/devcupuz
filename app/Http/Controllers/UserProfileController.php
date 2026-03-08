<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function show($username)
    {
        // 1. Foydalanuvchini yuklash
        $user = User::with(['university', 'medals' => function ($q) {
            $q->orderByPivot('created_at', 'desc');
        }])->where('username', $username)->firstOrFail();

        // 2. Umumiy yechilgan masalalar
        $totalSolved = Submission::where('user_id', $user->id)
            ->where('status', '2')
            ->distinct('problem_id')
            ->count();

        // 3. Dasturlash tillari bo'yicha guruhlangan statistika
        $languageStats = \App\Models\Submission::where('user_id', $user->id)
            ->join('programs', 'submissions.program_id', '=', 'programs.id')
            ->select(
                'programs.code',
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total_attempts'),
                \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN submissions.status = "2" THEN 1 ELSE 0 END) as accepted'),
                \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN submissions.status != "2" THEN 1 ELSE 0 END) as failed')
            )
            ->groupBy('programs.code')
            ->get();

        // 4. Faollik grafigi
        $activityData = Submission::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subYear())
            ->select(\Illuminate\Support\Facades\DB::raw('DATE(created_at) as date'), \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        $activityJson = json_encode($activityData);

        if (auth()->check()) view('profile', compact(['user', 'totalSolved', 'languageStats', 'activityJson']));
        else return view('auth.profile', compact(['user', 'totalSolved', 'languageStats', 'activityJson']));
    }
}
