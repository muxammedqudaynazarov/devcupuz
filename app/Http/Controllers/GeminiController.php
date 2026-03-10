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
            "- 90-100%: Xulosa va qaror qabul qila olish, ijodiy fikrlay olish, misollar keltirish va javob mohiyatini to‘liq ochib bera olish, mustaqil fikrlay olish, berilgan javob orqali aniq tushunchani aniqlay olish, amalda qo‘llay olish, mazmunini tushunish, bilish, aytib yoki yozib bera olish, tushunchaga ega bo‘lish, xatosiz ketma-ketlikda yozishiga yoki aytilishiga erishish, ma’no-mohiyatga ega javob berish, keltirilgan aniqlamalarga (atamalarga, turlarga, xodisalarga, tiplarga) misollar keltirish orqali javob bera olish.\n" .
            "- 70-89%: Erkin fikrlay olish, amalda qo‘llay olish, mazmunini tushunish, ketma-ketliksiz yozish, tasavvurga ega bo‘lish, xatosiz yozish yoki aytib berish, to‘liq bo‘lmagan javob berish, mohiyatini anglash lekin to‘liq bayon eta olmaslik.\n" .
            "- 60-69%: Mazmuni va mohiyatini tushunish, bilish, yozish yoki ayta olish, tushunchaga ega bo‘lish, ketma-ketlikni keltira olmaslik, mohiyatini bayon tushunarli tartibda bayon eta olmaslik, chala yozish yoki aytib berish.\n" .
            "- 1-59%: Yetarlicha tavsiflay olmaslik, to‘liq bilmaslik, ketma-ketliklarning mavjud emasligi yoki qoldirib ketilganligi, mohiyatini anglay olmaslik, chala tushunchaga ega bo‘lish, javob berishga harakat etganlik, to‘liq bo‘lmagan yoki oxiriga yetkazilmagan javob berish.\n" .
            "0%: Bilmaslik, tushuna olmaslik yoki tushunchaga ega bo‘lmaslik.\n" .
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
