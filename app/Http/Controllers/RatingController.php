<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $students = User::paginate(10);
        return view('ranking', compact(['students']));
    }
}
