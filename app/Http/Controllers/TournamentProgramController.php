<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentProgramController extends Controller
{
    public function edit($id)
    {
        $tournament = Tournament::with('programs')->findOrFail($id);
        $all_programs = Program::where('status', '1')->orderBy('name')->get();
        return view('admin.tournaments.options.programs.edit', compact(['tournament', 'all_programs']));
    }

    public function update(Request $request, $id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->programs()->sync($request->programs);
        return redirect()->back()->with('success', 'Dasturlash tillari muvaffaqiyatli yangilandi!');
    }
}
