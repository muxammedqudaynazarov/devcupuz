<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->can('user.ratings.view')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        $activeApp = \DB::table('tournament_users')->where('user_id', $user->id)
            ->where('status', '1')->where('active', '1')->first();
        if (!$activeApp) {
            return redirect()->back()->with('error', 'Sizda hozirda faol turnir mavjud emas.');
        }
        $tournament = Tournament::findOrFail($activeApp->tournament_id);
        $ratings = Rating::with('user')
            ->where('tournament_id', $tournament->id)
            ->orderBy('score', 'desc')    // 1. Eng yuqori ball
            ->orderBy('penalty')  // 3. Kam jarima (vaqt)
            ->orderBy('attempts') // 2. Kam urinish
            ->orderBy('secret') // 2. Kam urinish
            ->paginate(auth()->user()->per_page);

        return view('student.ratings.index', compact(['ratings', 'tournament']));
    }
}
