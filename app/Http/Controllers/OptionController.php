<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->can('user.settings.view')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        return view('student.options', compact(['user']));
    }

    public function store(Request $request)
    {
        // Ma'lumotlarni tekshirish (Validatsiya)
        $user = Auth::user();
        if (!$user->can('user.settings.edit')) return redirect()->back()->with('error', 'Sahifa topilmadi');
        $request->validate([
            'per_page' => 'required|integer|min:10|max:100',
            'theme' => 'required|string',
            'language' => 'required|in:uz,ru,kaa',
        ]);

        $user = Auth::user();

        // Sozlamalarni yangilash
        $user->update([
            'per_page' => $request->per_page,
            'theme' => $request->theme,
            'language' => $request->language,
        ]);

        return redirect()->back()->with('success', 'Sozlamalar muvaffaqiyatli saqlandi!');
    }
}
