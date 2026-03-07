<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;

class GeminiController extends Controller
{
    public function index()
    {
        //phpinfo();
        return view('gemini.upload');
    }

    public function models()
    {
        $response = Gemini::models()->list();
        $availableModels = [];

        foreach ($response->models as $model) {
            $availableModels[] = $model->name;
        }

        return $availableModels;
    }

    // Fayl va promptni API ga yuborish
    public function analyze(Request $request)
    {
        // 1. PHP va Laravel xotirasini vaqtincha oshiramiz (katta fayllar uchun)
        ini_set('memory_limit', '1024M');
        set_time_limit(300); // 5 daqiqa kutishga ruxsat

        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,png|max:15360', // 15MB gacha
            'prompt' => 'required|string',
        ]);

        $file = $request->file('document');

        // Faylni o'qish va base64 formatiga o'tkazish
        $fileContent = base64_encode(file_get_contents($file->path()));

        $prompt = "Talabaning javoblarini quyidagi «Bilim darajasi» mezonlari asosida har bir savolga 10 ballik mezonda, umumiy 50 ballik shkalada baholang:\n" .
            "- 90-100%: xulosa va qaror qabul qila olish, mustaqil fikrlay olish.\n" .
            "- 70-89%: Mazmunini aniq tushunish, erkin fikrlash.\n" .
            "- 60-69%: Mazmunini tushunish va ayta olish.\n" .
            "- 1-59%: Yetarlicha ta’riflay olmaslik.\n" .
            "0%: Bilmaslik.\n" .
            "Savollar bo‘yicha qisqacha bayonnama yozib bering, ortiqcha narsa shart emas. Misoli uchun:\n" .
            "**1 - savol: Cikl operatorlari**\n" .
            "**Javob holati va kamchiliklari:** Talaba savol sarlavhasini yozgan, lekin tsikllar(operatorlar) haqida ma'lumot berish o'rniga, o'zgaruvchilarning ko'rinish sohasi(scope) haqida yozgan . Mazmun savolga mutlaqo mos kelmaydi . Tsikllar o'rniga boshqa mavzu (scope) yoritilgan.\n" .
            "**Baholash:** 1-59% oralig‘ida (2.0 ball), yetarli ta’riflay olmaslik" .
            "... har savolga shu tahlitda qisqa aniqlama berib keting iltimos!";


        $extension = strtolower($file->getClientOriginalExtension());

        $mimeTypeEnum = match ($extension) {
            'pdf' => MimeType::APPLICATION_PDF,
            'png' => MimeType::IMAGE_PNG,
            'jpg', 'jpeg' => MimeType::IMAGE_JPEG,
            default => MimeType::IMAGE_JPEG,
        };

        try {
            $result = Gemini::generativeModel('gemini-2.5-pro')->generateContent([
                $prompt,
                new Blob(
                    mimeType: $mimeTypeEnum, // Bu yerda endi String emas, Enum ketyapti
                    data: $fileContent
                )
            ]);

            $analysisResult = $result->text();
        } catch (\Exception $e) {
            $analysisResult = "Xatolik yuz berdi: " . $e->getMessage();
        }

        return view('gemini.upload', [
            'result' => $analysisResult,
            'prompt' => $request->prompt
        ]);
    }
}
