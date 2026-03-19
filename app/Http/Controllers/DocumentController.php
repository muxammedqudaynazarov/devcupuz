<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToImage\Enums\OutputFormat;
use Spatie\PdfToImage\Pdf;

class DocumentController extends Controller
{
    public function index()
    {
        phpinfo();
        // $documents = Document::latest()->paginate(10);
        // return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        // 1. Validatsiya
        $request->validate([
            'name' => 'required|array',
            'name.uz' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ]);

        // 2. PDF Faylni saqlash
        $pdfPath = $request->file('file')->store('documents/pdf', 'public');
        $fullPdfPath = storage_path('app/public/' . $pdfPath);
        $splashPath = null;

        // 3. PDF dan birinchi sahifani rasm qilib olish
        try {
            // Splash rasm uchun papka yaratish
            if (!Storage::disk('public')->exists('documents/splash')) {
                Storage::disk('public')->makeDirectory('documents/splash');
            }

            $splashName = 'splash_' . time() . '_' . uniqid() . '.jpg';
            $splashRelativePath = 'documents/splash/' . $splashName;
            $splashAbsolutePath = storage_path('app/public/' . $splashRelativePath);

            // Spatie PDF to Image (v3) to'g'ri sintaksisi:
            $pdf = new Pdf($fullPdfPath);

            $pdf->selectPage(1) // setPage o'rniga selectPage()
            ->format(OutputFormat::Jpg)
                ->save($splashAbsolutePath); // saveImage() o'rniga save() ishlatiladi

            $splashPath = $splashRelativePath;

        } catch (\Exception $e) {
            // Agar serverda Imagick yoki Ghostscript yo'q bo'lsa xato berishi mumkin
            Log::error('PDF splash yaratishda xatolik: ' . $e->getMessage());
        }

        // 4. Bazaga yozish
        Document::create([
            'name' => $request->name, // JSON formatda saqlanadi (Modelda cast 'array' bo'lishi kerak)
            'file' => $pdfPath,
            'splash' => $splashPath,
        ]);

        return redirect()->route('documents.index')->with('success', 'Hujjat muvaffaqiyatli saqlandi!');
    }
}
