<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\System\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Ro'yxatdan o'tish formasini ko'rsatish
    public function showRegistrationForm()
    {
        $universities = University::all();
        return view('auth.register', compact('universities'));
    }

    public function register(Request $request)
    {
        // 1. Validatsiya
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'university_id' => ['required', 'exists:universities,id'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols(),],
        ]);

        // 2. Foydalanuvchini yaratish
        $user = User::create([
            'name' => json_encode([
                'full' => $request->first_name . ' ' . $request->last_name,
                'short' => $request->last_name . ' ' . substr($request->first_name, 0, 1) . '.',
            ]),
            'username' => $request->username,
            'pos' => 'user',
            'rol' => json_encode(['user']),
            'university_id' => $request->university_id,
            'password' => Hash::make($request->password),
        ]);

        // 3. Tizimga kirish
        $user->assignRole($user->pos);
        Auth::login($user);
        return redirect()->route('home')->with('success', 'Xush kelibsiz!');
    }
}
