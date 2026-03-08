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

        // tournament_users jadvali orqali faol turnirni topamiz
        // Bu mantiq foydalanuvchining Pivot (tournament_user) jadvalidagi status va active ustunlariga qaraydi
        $activeApp = \DB::table('tournament_users')
            ->where('user_id', $user->id)
            ->where('status', '1')
            ->where('active', '1')
            ->first();

        if (!$activeApp) {
            return redirect()->back()->with('error', 'Sizda hozirda faol turnir mavjud emas.');
        }

        $tournament = Tournament::findOrFail($activeApp->tournament_id);

        // Reytingni uch darajali tartiblash
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
