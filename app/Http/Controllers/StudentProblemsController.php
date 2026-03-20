<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentProblemsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('user.tournaments.view')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        $userId = auth()->id();
        $tournaments = Tournament::whereIn('status', ['1', '3'])
            ->withCount(['users' => function ($query) {
                $query->where('tournament_users.status', '1');
            }])
            ->withExists(['users as is_applied' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->with(['users' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->select(['tournament_users.status', 'tournament_users.active']);
            }])
            ->paginate(auth()->user()->per_page);
        return view('student.tournaments.index', compact('tournaments'));
    }

    public function show($id)
    {
        if (!auth()->user()->can('user.tournaments.show')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        $tournament = Tournament::withCount('users')->findOrFail($id);
        $application = DB::table('tournament_users')->where('tournament_id', $id)
            ->where('user_id', auth()->id())->first();

        return view('student.tournaments.show', compact(['tournament', 'application']));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('user.tournaments.application.create')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        // 1. Turnirni va joriy foydalanuvchini aniqlash
        $tournament = Tournament::findOrFail($id);
        $user = auth()->user();

        // 2. Xavfsizlik tekshiruvlari
        if ($tournament->status != '1') return back()->with('error', 'Ushbu turnirga hozirda ariza topshirib bo‘lmaydi.');

        // Ariza topshirish muddati (deadline) o'tib ketmagan bo'lishi shart
        if (now()->greaterThan($tournament->deadline)) return back()->with('error', 'Arizalar qabul qilish muddati tugagan.');

        // 3. Ariza borligini tekshirish va yozish
        $user->tournaments()->syncWithoutDetaching([
            $id => [
                'status' => '0',
                'active' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        return back()->with('success', 'Arizangiz muvaffaqiyatli yuborildi. Moderatsiya tasdiqlashini kuting.');
    }


    public function activated(Request $request)
    {
        if (!auth()->user()->can('user.tournaments.view')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        // 1. Kirish ma'lumotlarini validatsiya qilish
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
        ]);

        $userId = auth()->id();
        $tournamentId = $request->tournament_id;

        // 2. Foydalanuvchining ushbu turnirda statusi '1' bo'lgan arizasi borligini tekshirish
        $tournament = Tournament::where('id', $tournamentId)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('tournament_users.status', '1');
            })->first();

        if (!$tournament) {
            return redirect()->back()->with('error', 'Sizda ushbu turnirga kirish huquqi yo‘q yoki arizangiz hali tasdiqlanmagan.');
        }

        // 3. FOQAT BITTA TURNIR AKTIV BO'LISHI UCHUN:
        // Avval foydalanuvchining barcha turnirlarini 'active' = '0' holatiga o'tkazamiz
        \DB::table('tournament_users')
            ->where('user_id', $userId)
            ->update(['active' => '0']);

        // 4. Tanlangan turnirni 'active' = '1' holatiga yangilaymiz
        $tournament->users()->updateExistingPivot($userId, [
            'active' => '1'
        ]);

        return redirect()->route('problems.index')
            ->with('success', 'Turnir muvaffaqiyatli faollashtirildi! Qolgan turnirlar nofaol holatga o‘tkazildi.');
    }
}
