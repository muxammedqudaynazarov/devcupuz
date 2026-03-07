<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $problems = 0;
        $points = 0;
        $position = 1;
        $positions = 2;
        $coefficient = 2;
        $users = User::take(5)->get();
        return view('home', compact(['users', 'problems', 'position', 'positions', 'coefficient', 'points']));
    }

    public function switch_role($role)
    {
        $user = Auth::user();
        $rols = $user->hemis_roles;
        if (is_string($rols)) {
            $rols = json_decode($rols, true);
        }
        if (!is_array($rols)) {
            $rols = [];
        }
        if (in_array($role, $rols)) {
            $user->removeRole($user->current_role);
            $user->current_role = $role;
            $user->assignRole($role);
            $user->save();
            return redirect(route('home'))->with('success', 'Rol o‘zgartirildi');
        }
        return redirect(route('home'))->with('error', 'Sizda bu rol mavjud emas!');
    }
}
