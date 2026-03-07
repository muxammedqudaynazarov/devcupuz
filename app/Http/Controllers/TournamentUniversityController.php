<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\System\University;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentUniversityController extends Controller
{
    public function edit($id)
    {
        $tournament = Tournament::with('programs')->findOrFail($id);
        $universities = University::where('status', '1')->get();
        if (count($universities) <= 1) {
            return redirect()->route('tournaments.index')
                ->with('error', 'O‘zgartirish uchun faol OTM yo‘q.');
        }
        return view('admin.tournaments.options.universities.edit', compact(['tournament', 'universities']));
    }

    public function update(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->universities()->sync($request->programs);
        return redirect()->back()->with('success', 'Dasturlash tillari muvaffaqiyatli yangilandi!');
    }
}
