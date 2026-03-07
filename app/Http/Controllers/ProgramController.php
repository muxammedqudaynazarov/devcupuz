<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('name')->paginate(10);
        return view('admin.programs.index', compact(['programs']));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'field' => 'required|in:default,status',
            'value' => 'required|in:0,1',
        ]);

        $program = Program::findOrFail($id);
        $field = $request->field;
        $value = $request->value;
        if ($field === 'default' && $value === '1') {
            Program::where('id', '!=', $program->id)->update(['default' => '0']);
        }
        $program->$field = $value;
        $program->save();

        return response()->json([
            'success' => true,
            'message' => 'Holat o\'zgartirildi'
        ]);
    }
}
