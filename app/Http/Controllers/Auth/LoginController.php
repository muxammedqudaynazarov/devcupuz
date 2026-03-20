<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Log;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = [
            'username' => strtolower($request->username),
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();
            if ($user->status == '3') {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Sizning hisobingiz bloklangan! Ma\'muriyat bilan bog\'laning.',
                ]);
            }
            $request->session()->regenerate();
            try {
                /*$sms_text = __('welcome.Login sms push', [
                    'year' => date('Y'),
                    'date' => date('d'), 'month' => __('welcome.months_full_l.' . date('m')),
                    'clock' => date('H:i')
                ]);
                Http::withHeaders(['Accept' => 'application/json'])
                    ->post('https://test.regofis.uz/api/getsms/send', [
                        'phone' => $user->phone,
                        'text' => "DevCup: " . $sms_text . "\nIP: " . $request->ip(),
                    ]);*/
            } catch (\Exception $e) {
                Log::error("SMS yuborishda xatolik: " . $e->getMessage());
            }
            return redirect()->intended(route('home'))->with('success', 'Xush kelibsiz!');
        }
        return back()->withErrors([
            'login' => 'Kiritilgan ma’lumotlar tizimdagi ma’lumotlarga mos kelmadi.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
