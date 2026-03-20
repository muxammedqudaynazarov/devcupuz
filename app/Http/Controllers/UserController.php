<?php

namespace App\Http\Controllers;
// Agar admin papkasida bo'lsa

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('university')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|array',
            'name.full' => 'required|string|max:255',
            'name.short' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|unique:users,phone,' . $user->id,
            'rol' => 'nullable|array',
        ]);
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'rol' => $request->rol ?? [],
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            Http::withHeaders(['Accept' => 'application/json',])->post('https://test.regofis.uz/api/getsms/send', [
                'phone' => $user->phone,
                'text' => "DevCup: parolingiz administrator tomonidan o‘zgartirildi.\nYangi parol: " . $request->password,
            ]);
        }
        if ($request->filled('blocked')) {
            $data['status'] = '3';
        } elseif ($user->status == '3') {
            $data['status'] = '0';
            $data['phone'] = null;
        }
        $user->update($data);
        return redirect()->route('users.index')
            ->with('success', 'Foydalanuvchi ma’lumotlari muvaffaqiyatli yangilandi!');
    }
}
