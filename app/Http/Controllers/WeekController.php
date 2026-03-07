<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function show($id)
    {
        $tournament = Tournament::with(['weeks' => function ($query) {
            $query->orderBy('week_number', 'asc');
        }])->findOrFail($id);
        return view('admin.tournaments.options.weeks.show', compact(['tournament']));
    }

    public function edit($tournament_id)
    {
        $tournament = Tournament::findOrFail($tournament_id);
        $nextWeekNumber = $tournament->weeks()->max('week_number') + 1;
        return view('admin.tournaments.options.weeks.edit', compact(['tournament', 'nextWeekNumber']));
    }

    public function week_edit($tournament_id, $week_id)
    {
        $tournament = Tournament::findOrFail($tournament_id);
        $week = Week::findOrFail($week_id);

        // 1-shart: Tur aynan shu turnirga tegishlimi?
        if ($week->tournament_id != $tournament->id) return back()->with('error', 'Bu tur ushbu turnirga tegishli emas.');

        // 2-shart: Turnir statusi 3 (Yakunlangan) yoki 4 (Qoldirilgan) emasmi?
        if (in_array($tournament->status, ['3', '4'])) return back()->with('error', 'Yakunlangan yoki qoldirilgan turnirning turlarini tahrirlab bo‘lmaydi.');

        // 3-shart: Joriy vaqt turning tugash vaqtidan o'tib ketmaganmi?
        if (now()->greaterThan(Carbon::parse($week->finished))) return back()->with('error', 'Yakuniga yetgan turni tahrirlab bo‘lmaydi.');

        // 4-shart: O'zidan keyin boshqa tur yaratilganmi?
        $hasNextWeek = Week::where('tournament_id', $tournament->id)->where('week_number', '>', $week->week_number)->exists();
        if ($hasNextWeek) return back()->with('error', 'Ushbu turdan so‘ng boshqa tur yaratilganligi sababli o‘zgartirib bo‘lmaydi.');

        return view('admin.tournaments.options.weeks.week_edit', compact(['tournament', 'week']));
    }

    public function week_destroy($tournament_id, $week_id)
    {
        $tournament = Tournament::findOrFail($tournament_id);
        $week = Week::findOrFail($week_id);

        // 1-shart: Tur aynan shu turnirga tegishlimi?
        if ($week->tournament_id != $tournament->id) return back()->with('error', 'Bu tur ushbu turnirga tegishli emas.');

        // 2-shart: Turnir statusi 3 (Yakunlangan) yoki 4 (Qoldirilgan) emasmi?
        if (in_array($tournament->status, ['3', '4'])) return back()->with('error', 'Yakunlangan yoki qoldirilgan turnirning turlarini tahrirlab bo‘lmaydi.');

        // 3-shart: Joriy vaqt turning tugash vaqtidan o'tib ketmaganmi?
        if (now()->greaterThan(Carbon::parse($week->finished))) return back()->with('error', 'Yakuniga yetgan turni tahrirlab bo‘lmaydi.');

        // 4-shart: O'zidan keyin boshqa tur yaratilganmi?
        $hasNextWeek = Week::where('tournament_id', $tournament->id)->where('week_number', '>', $week->week_number)->exists();
        if ($hasNextWeek) return back()->with('error', 'Ushbu turdan so‘ng boshqa tur yaratilganligi sababli o‘zgartirib bo‘lmaydi.');

        $week->delete();
        return back()->with('success', 'Hafta (tur) o‘chirildi.');
    }

    // 2. O'zgarishlarni saqlash
    public function week_update(Request $request, $tournament_id, $week_id)
    {
        $tournament = Tournament::findOrFail($tournament_id);
        $week = Week::findOrFail($week_id);

        // Xavfsizlik uchun tekshiruvlarni bu yerda ham takrorlaymiz
        if ($week->tournament_id != $tournament->id ||
            in_array($tournament->status, ['3', '4']) ||
            now()->greaterThan(Carbon::parse($week->finished))) {
            return back()->with('error', 'Ushbu turni tahrirlash huquqi cheklangan.');
        }

        $tStarted = Carbon::parse($tournament->started);
        $tFinished = Carbon::parse($tournament->finished);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'started' => [
                'required', 'date',
                'after_or_equal:' . $tStarted->toDateTimeString()
            ],
            'finished' => [
                'required', 'date', 'after:started',
                'before_or_equal:' . $tFinished->toDateTimeString()
            ],
        ], [
            'started.after_or_equal' => "Boshlanish vaqti turnir boshlanishidan (" . $tStarted->format('d.m.Y H:i') . ") oldin bo'lishi mumkin emas.",
            'finished.before_or_equal' => "Yakunlanish vaqti turnir yakunidan (" . $tFinished->format('d.m.Y H:i') . ") o'tib ketishi mumkin emas.",
        ]);

        // Avvalgi turning yakunidan keyin boshlanishini tekshirish
        $previousWeek = Week::where('tournament_id', $tournament->id)
            ->where('week_number', '<', $week->week_number)
            ->orderBy('week_number', 'desc')
            ->first();

        if ($previousWeek) {
            $prevFinished = Carbon::parse($previousWeek->finished);
            if (Carbon::parse($request->started)->lt($prevFinished)) {
                return back()->withErrors([
                    'started' => "Boshlanish vaqti avvalgi bosqich yakunidan (" . $prevFinished->format('d.m.Y H:i') . ") keyin bo'lishi shart."
                ])->withInput();
            }
        }

        // Ma'lumotlarni yangilash (week_number kiritilmagan, chunki uni o'zgartirish taqiqlangan)
        $week->update($validatedData);

        // Turnir turlari ro'yxatiga qaytarish (turnirni ko'rish sahifasiga moslang)
        return redirect()->route('weeks.show', $tournament->id)
            ->with('success', "{$week->week_number}-bosqich muvaffaqiyatli yangilandi!");
    }

    public function update(Request $request, $tournament_id)
    {
        $tournament = Tournament::findOrFail($tournament_id);
        $validatedData = $request->validate([
            'week_number' => 'required|integer',
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'started' => [
                'required',
                'date',
                'after:' . $tournament->started->format('Y-m-d H:i'),
            ],
            'finished' => [
                'required',
                'date',
                'after:started',
                'before:' . $tournament->finished->format('Y-m-d H:i'),
            ],
        ], [
            'started.after_or_equal' => "Tur boshlanishi turnir boshlanishidan o'tib ketmasligi kerak (" . $tournament->started->format('d.m.Y H:i') . ").",
            'finished.before_or_equal' => "Tur tugashi turnir yakunidan o'tib ketmasligi kerak (" . $tournament->finished->format('d.m.Y H:i') . ").",
        ]);

        $previousWeek = Week::where('tournament_id', $tournament->id)
            ->where('week_number', '<', $request->week_number)
            ->orderBy('week_number', 'desc')->first();

        if ($previousWeek && \Carbon\Carbon::parse($request->started)->lt($previousWeek->finished)) {
            return back()->withErrors([
                'started' => "Yangi tur boshlanishi avvalgi turning yakunidan (" . $previousWeek->finished->format('d.m.Y H:i') . ") keyin bo'lishi shart."
            ])->withInput();
        }
        Week::create([
            'name' => $request->name,
            'tournament_id' => $tournament->id,
            'week_number' => $request->week_number,
            'status' => $request->status,
            'started' => $request->started,
            'finished' => $request->finished,
        ]);
        return redirect()->route('weeks.show', $tournament->id)->with('success', 'Tur muvaffaqiyatli yangilandi!');
    }
}
