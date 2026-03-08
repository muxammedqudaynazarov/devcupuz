<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('student.options', compact(['user']));
    }

    public function store(Request $request)
    {
        // Ma'lumotlarni tekshirish (Validatsiya)
        $request->validate([
            'per_page' => 'required|integer|min:10|max:100',
            'theme'    => 'required|string',
            'language' => 'required|in:uz,ru,kaa',
        ]);

        $user = Auth::user();

        // Sozlamalarni yangilash
        $user->update([
            'per_page' => $request->per_page,
            'theme'    => $request->theme,
            'language' => $request->language,
        ]);

        return redirect()->back()->with('success', 'Sozlamalar muvaffaqiyatli saqlandi!');
    }
}
