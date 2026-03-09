<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // Order bo'yicha o'sish tartibida chiqaramiz
        $faqs = Faq::orderBy('order', 'asc')->paginate(auth()->user()->per_page ?? 15);
        return view('admin.faqs.index', compact(['faqs']));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $locale = app()->getLocale();
        $request->validate([
            "question.{$locale}" => 'required|string',
            "answer.{$locale}" => 'required|string',
        ]);
        $maxOrder = Faq::max('order') ?? 0;
        Faq::create([
            'question' => [$locale => $request->input("question.{$locale}")],
            'answer' => [$locale => $request->input("answer.{$locale}")],
            'order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'Yangi FAQ muvaffaqiyatli saqlandi!');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact(['faq']));
    }

    public function update(Request $request, Faq $faq)
    {
        $locale = app()->getLocale();
        $request->validate([
            "question.{$locale}" => 'required|string',
            "answer.{$locale}" => 'required|string',
        ]);

        $faq->update([
            'question' => [$locale => $request->input("question.{$locale}")],
            'answer' => [$locale => $request->input("answer.{$locale}")],
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ muvaffaqiyatli yangilandi!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ o‘chirildi!');
    }

    public function moveUp(Faq $faq)
    {
        $previous = Faq::where('order', '<', $faq->order)->orderBy('order', 'desc')->first();

        if ($previous) {
            $tempOrder = $faq->order;
            $faq->update(['order' => $previous->order]);
            $previous->update(['order' => $tempOrder]);
        }

        return back();
    }

    // PASTGA SURISH
    public function moveDown(Faq $faq)
    {
        $next = Faq::where('order', '>', $faq->order)->orderBy('order', 'asc')->first();

        if ($next) {
            $tempOrder = $faq->order;
            $faq->update(['order' => $next->order]);
            $next->update(['order' => $tempOrder]);
        }

        return back();
    }
}
