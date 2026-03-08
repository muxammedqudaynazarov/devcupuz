<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Medal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->status == '1') {
            return redirect()->route('student.tournaments.index');
        }
        $step = session()->has('sms_code') ? 'step2' : 'step1';
        return view('auth.verify', compact('step'));
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'numeric', 'digits:12', 'regex:/^998\d{9}$/']
        ], [
            'phone.regex' => 'Raqam to‘liq va belgilarsiz kiritilishi kerak (Masalan: 998901234567).',
            'phone.digits' => 'Telefon raqami formatida xatolik.'
        ]);
        $phone = $request->phone;
        if (session()->has('last_sms_sent') && now()->diffInSeconds(session('last_sms_sent')) < 60) {
            return response()->json([
                'success' => false,
                'message' => 'SMS yuborish uchun 60 soniya kuting.'
            ], 429);
        }
        $code = rand(100000, 999999);
        try {
            $response = Http::withHeaders(['Accept' => 'application/json',])->post('https://test.regofis.uz/api/getsms/send', [
                'phone' => $phone,
                'text' => "DevCup tasdiqlash kodi: $code",
            ]);
            if ($response->successful()) {
                session([
                    'sms_code' => $code,
                    'verify_phone' => $phone,
                    'verify_attempts' => 0,
                    'last_sms_sent' => now(),
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Tasdiqlash kodi yuborildi!',
                    'test_code' => app()->environment('local') ? $code : null // Faqat localda ko'rinadi
                ]);
            }
            throw new \Exception('API xatoligi: ' . $response->status());
        } catch (\Exception $e) {
            Log::error("SMS yuborishda xato: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'SMS xizmatida xatolik yuz berdi.'
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);
        $attempts = session('verify_attempts', 0);
        if ($request->code == session('sms_code')) {
            $verifyMedal = Medal::where('type', 'verify')->first();
            $user = auth()->user();
            $user->phone = session('verify_phone');
            $user->status = '1';
            $user->save();
            $user->medals()->syncWithoutDetaching([$verifyMedal->id]);
            session()->forget(['sms_code', 'verify_phone', 'verify_attempts']);
            return redirect()->route('student.tournaments.index')->with('success', 'Profilingiz tasdiqlandi!');
        }
        $attempts++;
        session(['verify_attempts' => $attempts]);
        if ($attempts >= 3) {
            session()->forget(['sms_code', 'verify_attempts']);
            return redirect()->route('student.verify')
                ->with('error', '3 marta xato kiritildi. Iltimos, raqamni qayta tasdiqlab, yangi kod oling.');
        }
        $remaining = 3 - $attempts;
        return back()->withErrors(['code' => "Kod noto‘g‘ri. Yana $remaining ta urinish qoldi."]);
    }
}
