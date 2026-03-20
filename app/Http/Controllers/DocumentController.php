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
        $documents = Document::latest()->paginate(10);
        return view('admin.documents.index', compact(['documents']));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.uz' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ]);
        $pdfPath = $request->file('file')->store('documents/pdf', 'public');
        $fullPdfPath = storage_path('app/public/' . $pdfPath);
        $splashPath = null;
        try {
            if (!Storage::disk('public')->exists('documents/splash')) {
                Storage::disk('public')->makeDirectory('documents/splash');
            }
            $splashName = 'splash_' . time() . '_' . uniqid() . '.jpg';
            $splashRelativePath = 'documents/splash/' . $splashName;
            $splashAbsolutePath = storage_path('app/public/' . $splashRelativePath);
            $pdf = new Pdf($fullPdfPath);
            $pdf->selectPage(1)->format(OutputFormat::Jpg)->save($splashAbsolutePath);
            $splashPath = $splashRelativePath;
        } catch (\Exception $e) {
            Log::error('PDF splash yaratishda xatolik: ' . $e->getMessage());
            return redirect()->back()->with('error', 'PDF splash yaratishda xatolik');
        }
        Document::create([
            'name' => $request->name,
            'file' => $pdfPath,
            'splash' => $splashPath,
        ]);

        return redirect()->route('documents.index')->with('success', 'Hujjat muvaffaqiyatli saqlandi!');
    }

    public function update(Request $request, Document $document)
    {
        $document->update([
            'status' => $document->status == '1' ? '0' : '1'
        ]);
        return response()->json(['success' => true]);
    }

    public function documents()
    {
        $documents = Document::where('status', '1')->get();
        return view('documents', compact(['documents']));
    }
}
