<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PrizeController extends Controller
{
    public function index()
    {
        $prizes = Prize::latest()->paginate(auth()->user()->per_page);
        return view('admin.prizes.index', compact(['prizes']));
    }

    public function create()
    {
        return view('admin.prizes.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'actual' => 'required|in:0,1',
        ]);
        $imagePath = $request->file('image')->store('prizes', 'public');
        if ($request->actual == '1') {
            DB::table('prizes')->update(['actual' => '0']);
        }
        Prize::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'image' => $imagePath,
            'actual' => $request->actual,
        ]);
        return redirect()->route('prizes.index')->with('success', 'Yangi sovrin muvaffaqiyatli qo‘shildi!');
    }

    public function edit(Prize $prize)
    {
        return view('admin.prizes.form', compact(['prize']));
    }

    public function update(Request $request, Prize $prize)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'actual' => 'required|in:0,1',
        ]);
        $data = [
            'title' => $request->title,
            'desc' => $request->desc,
            'actual' => $request->actual,
        ];
        if ($request->hasFile('image')) {
            if ($prize->image && Storage::disk('public')->exists($prize->image)) {
                Storage::disk('public')->delete($prize->image);
            }
            $data['image'] = $request->file('image')->store('prizes', 'public');
        }
        $prize->update($data);
        return redirect()->route('prizes.index')->with('success', 'Sovrin ma’lumotlari yangilandi!');
    }

    public function destroy(Prize $prize)
    {
        if ($prize->image && Storage::disk('public')->exists($prize->image)) {
            Storage::disk('public')->delete($prize->image);
        }
        $prize->delete();
        return redirect()->route('prizes.index')->with('success', 'Sovrin tizimdan o‘chirildi!');
    }
}
