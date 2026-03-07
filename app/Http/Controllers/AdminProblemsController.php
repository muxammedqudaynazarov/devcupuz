<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Tournament;
use Illuminate\Http\Request;

class AdminProblemsController extends Controller
{
    public function index()
    {
        $problems = Problem::with('week.tournament')->latest('id')->paginate(10);
        return view('admin.problems.index', compact(['problems']));
    }

    public function create()
    {
        $tournaments = Tournament::with(['weeks' => function ($query) {
            $query->withCount('problems') // Har bir week uchun problems_count maydonini qo'shadi
            ->orderBy('week_number', 'asc');
        }])
            ->whereIn('status', ['0', '1'])
            ->get();
        return view('admin.problems.create', compact('tournaments'));
    }

    public function store(Request $request)
    {
        // 1. Ma'lumotlarni validatsiya qilish
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'week_id' => 'required|exists:weeks,id',
            'memory' => 'required|integer|min:1',
            'runtime' => 'required|numeric|min:0.1',
            'point' => 'required|integer|min:1',
            'desc' => 'required|string',
            'input_text' => 'required|string',
            'output_text' => 'required|string',
            // Massivlarni tekshirish (Kamida 1 ta namuna bo'lishi shart)
            'test_input' => 'required|array|min:1',
            'test_input.*' => 'required|string',
            'test_output' => 'required|array|min:1',
            'test_output.*' => 'required|string',
        ], [
            'name.required' => 'Masala nomini kiritish majburiy.',
            'week_id.required' => 'Turnir va bosqichni tanlash majburiy.',
            'desc.required' => 'Masalaning to‘liq sharti yozilishi shart.',
            'test_input.required' => 'Kamida bitta kiruvchi namuna (input) kiritilishi shart.',
            'test_output.required' => 'Kamida bitta chiquvchi namuna (output) kiritilishi shart.',
        ]);

        // 2. Dinamik misollarni (Examples) JSON formatga o'tkazish
        $examples = [];
        $inputs = $request->input('test_input');
        $outputs = $request->input('test_output');

        // Massivlarni birlashtirib, tartibli strukturaga keltiramiz
        for ($i = 0; $i < count($inputs); $i++) {
            $examples[] = [
                'input' => $inputs[$i],
                'output' => $outputs[$i]
            ];
        }

        // 3. Masalani bazaga saqlash
        Problem::create([
            'name' => $validatedData['name'],
            'week_id' => $validatedData['week_id'],
            'user_id' => auth()->id(), // Masalani qo'shayotgan admin ID si
            'memory' => $validatedData['memory'],
            'runtime' => $validatedData['runtime'],
            'point' => $validatedData['point'],
            'desc' => $validatedData['desc'],
            'input_text' => $validatedData['input_text'],
            'output_text' => $validatedData['output_text'],
            'example' => json_encode($examples), // Massivni JSON satriga aylantiramiz
        ]);

        // 4. Muvaffaqiyat xabari bilan ro'yxatga qaytarish
        return redirect()->route('admin.problems.index')
            ->with('success', 'Yangi masala muvaffaqiyatli saqlandi!');
    }
}
