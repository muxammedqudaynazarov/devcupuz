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
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase(),],
        ], [
            'first_name.required' => __('welcome.First name is required.'),
            'first_name.string' => __('welcome.First name must be a string.'),
            'first_name.max' => __('welcome.First name cannot be longer than 64 characters.'),
            'last_name.required' => __('welcome.Last name is required.'),
            'last_name.string' => __('welcome.Last name must be a string.'),
            'last_name.max' => __('welcome.Last name cannot be longer than 64 characters.'),
            'university_id.required' => __('welcome.University is required.'),
            'university_id.exists' => __('welcome.University is not found.'),
            'username.required' => __('welcome.Username is required.'),
            'username.string' => __('welcome.Username must be a string.'),
            'username.max' => __('welcome.Username cannot be longer than 64 characters.'),
            'username.unique' => __('welcome.Username is already taken.'),
            'password.required' => __('welcome.Password is required.'),
            'password.min' => __('welcome.Password must be at least 8 characters.'),
            'password.confirmed' => __('welcome.Password does not match.'),
            'password.mixed' => __('welcome.Password must be a mixed characters.'),
        ]);

        // 2. Foydalanuvchini yaratish
        $user = User::create([
            'name' => [
                'full' => $request->first_name . ' ' . $request->last_name,
                'short' => $request->last_name . ' ' . substr($request->first_name, 0, 1) . '.',
            ],
            'username' => strtolower($request->username),
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
