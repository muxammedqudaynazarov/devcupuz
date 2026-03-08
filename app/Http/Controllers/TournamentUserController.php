<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentUserController extends Controller
{
    public function show($id)
    {
        $tournament = Tournament::findOrFail($id);

// Paginatsiya so'rovining o'zida pivot va munosabatlarni yuklaymiz
        $applications = $tournament->users()
            ->with('university')
            ->withPivot('status', 'created_at')
            ->orderBy('tournament_users.created_at', 'desc')
            ->paginate(auth()->user()->per_page);

        return view('admin.tournaments.options.applications.edit', compact(['tournament', 'applications']));
    }

    /**
     * Arizani qabul qilish yoki bekor qilish uchun metod
     */
    public function updateApplication(Request $request, $tournamentId, $userId)
    {
        $request->validate([
            'status' => 'required|in:1,2', // 1: Qabul qilish, 2: Bekor qilish
        ]);

        $tournament = Tournament::findOrFail($tournamentId);

        // Pivot jadvaldagi statusni yangilash
        $tournament->users()->updateExistingPivot($userId, [
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        $message = $request->status == '1' ? 'Ariza qabul qilindi' : 'Ariza bekor qilindi';

        return redirect()->back()->with('success', $message);
    }
}
