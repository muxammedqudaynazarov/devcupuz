<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('admin.programs.view')) return redirect()->back()->with('error', 'Sahifa topilmadi!');
        $programs = Program::orderBy('name')->paginate(auth()->user()->per_page);
        return view('admin.programs.index', compact(['programs']));
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('admin.programs.edit')) return redirect()->back()->with('error', 'Sahifa topilmadi!');
        $request->validate([
            'field' => 'required|in:default,status',
            'value' => 'required|in:0,1',
        ]);

        $program = Program::findOrFail($id);
        $field = $request->field;
        $value = $request->value;
        $program->$field = $value;
        $program->save();

        return response()->json([
            'success' => true,
            'message' => 'Holat o\'zgartirildi'
        ]);
    }
}
