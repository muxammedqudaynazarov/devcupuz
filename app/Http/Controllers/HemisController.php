<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\System\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HemisController extends Controller
{
    public function student_login(Request $request)
    {
        if (!$request->has('university')) {
            $request->merge(['university' => 346]);
        }

        $request->validate([
            'university' => 'required|exists:universities,id',
            'login' => 'required',
            'password' => 'required',
        ]);

        try {
            $university = University::findOrFail($request->university);
            $baseUrl = rtrim($university->hemis_student_url, '/');
            $loginResponse = Http::timeout(10)->post($baseUrl . '/rest/v1/auth/login', [
                'login' => $request->login,
                'password' => $request->password,
            ]);
            if ($loginResponse->failed()) return back()->withErrors(['login' => 'Login yoki parol xato.'])->withInput();

            $studentData = $loginResponse->json();
            if (!isset($studentData['data']['token'])) return back()->withErrors(['login' => 'HEMIS tizimidan token olishda xatolik yuz berdi.'])->withInput();

            $token = $studentData['data']['token'];
            $accountResponse = Http::timeout(10)->withToken($token)->get($baseUrl . '/rest/v1/account/me');

            if ($accountResponse->failed()) return back()->withErrors(['login' => 'Ma’lumotlarni yuklashda xatolik.'])->withInput();
            $account = $accountResponse->json();

            if (!isset($account['data']['student_id_number'])) return back()->withErrors(['login' => 'Talaba identifikatsiya raqami (ID) topilmadi.'])->withInput();
            $userData = $account['data'];
            $user = User::updateOrCreate(
                ['id' => $userData['student_id_number']],
                [
                    'name' => json_encode([
                        'full' => $userData['full_name'] ?? null,
                        'short' => $userData['short_name'] ?? null,
                    ], JSON_UNESCAPED_UNICODE),
                    'hemis_id' => $userData['id'] ?? null,
                    'phone' => $userData['phone'] ?? null,
                    'image' => $userData['image'] ?? null,
                    'university_id' => $university->id,
                    'data' => json_encode($userData, JSON_UNESCAPED_UNICODE),
                ]
            );
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Tizimga muvaffaqiyatli kirdingiz!');
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return back()->withErrors(['login' => 'HEMIS serveri bilan aloqa o‘rnatib bo‘lmadi. Birozdan so‘ng qayta urinib ko‘ring.'])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Tizimda xatolik yuz berdi: ' . $e->getMessage()])->withInput();
        }
    }
}
