<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\System\University;
use App\Models\Tournament;
use App\Models\TournamentAdmin;
use App\Models\TournamentProgram;
use App\Models\TournamentUniversity;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('admin.tournaments.view')) return redirect()->back()->with('error', 'Sahifa topilmadi!');
        $tournaments = Tournament::paginate(auth()->user()->per_page);
        return view('admin.tournaments.index', compact(['tournaments']));
    }

    public function create()
    {
        if (!auth()->user()->can('admin.tournaments.create')) return redirect()->back()->with('error', 'Sahifa topilmadi!');
        return view('admin.tournaments.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('admin.tournaments.create')) return redirect()->back()->with('error', 'Sahifa topilmadi!');
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'started' => 'required|date',
            'finished' => 'required|date|after:started',
            'deadline' => 'required|date|before:started',
        ], [
            'finished.after' => 'Yakunlanish vaqti boshlanish vaqtidan keyin bo‘lishi kerak.',
            'deadline.before' => 'Ariza qabul qilish muddati turnir boshlanishidan oldin bo‘lishi shart.',
            'desc.required' => 'Turnir tasnifi maydonida turnir haqida ma’lumotlar to‘ldirilishi shart.'
        ]);
        $programs = Program::where('status', '1')->where('default', '1')->get();
        $universities = University::where('status', '1')->get();
        $tournament = Tournament::create([
            'name' => $validatedData['name'],
            'desc' => $validatedData['desc'],
            'started' => $validatedData['started'],
            'finished' => $validatedData['finished'],
            'deadline' => $validatedData['deadline'],
        ]);
        TournamentAdmin::create([
            'tournament_id' => $tournament->id,
            'user_id' => auth()->id(),
        ]);
        foreach ($programs as $program) {
            TournamentProgram::create([
                'tournament_id' => $tournament->id,
                'program_id' => $program->id,
            ]);
        }
        foreach ($universities as $university) {
            TournamentUniversity::create([
                'tournament_id' => $tournament->id,
                'university_id' => $university->id,
                //'user_id' => auth()->id(),
            ]);
        }
        return redirect()->route('tournaments.index')->with('success', 'Turnir muvaffaqiyatli yaratildi!');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('admin.tournaments.edit')) return redirect()->back()->with('error', 'Sahifa topilmadi!');
        $tournament = Tournament::findOrFail($id);
        if ($tournament) {
            if (!in_array($tournament->status, ['3', '4'])) {
                return view('admin.tournaments.edit', compact(['tournament']));
            } else return redirect()->route('tournaments.index')->with('error', 'Turnirni o‘zgartirib bo‘lmaydi!');
        }
    }

    public function update(Request $request, Tournament $tournament)
    {
        if (!auth()->user()->can('admin.tournaments.edit')) return redirect()->back()->with('error', 'Sahifa topilmadi!');
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'started' => 'required|date',
            'finished' => 'required|date|after:started',
            'deadline' => 'required|date|before:started',
            'status' => 'required|in:0,1,2,3,4',
        ], [
            'finished.after' => 'Yakunlanish vaqti boshlanish vaqtidan keyin bo‘lik kerak.',
            'deadline.before' => 'Ariza qabul qilish muddati turnir boshlanishidan oldin bo‘lishi shart.',
            'desc.required' => 'Turnir tasnifi maydonida turnir haqida ma’lumotlar to‘ldirilishi shart.'
        ]);
        $tournament->update($validatedData);
        return redirect()->route('tournaments.index')->with('success', 'Turnir muvaffaqiyatli yangilandi!');
    }
}
