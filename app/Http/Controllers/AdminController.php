<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return view('admin.panel');
        }
        return redirect('/')->withErrors('Nie masz uprawnień do tej strony.');
    }

    public function index2()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1|confirmed',
            'role' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|integer|max:9',
        ]);

        User::create([
            'login' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Dodano użytkownika do bazy danych.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users,'. $user->id,
            'email' => 'required|string|email|max:255|unique:users,' . $user->id,
            'password' => 'required|string|min:1',
            'role' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|integer|max:9',
        ]);

        $user->update([
            'login' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Zaktualizowano użytkownika.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usunięto użytkownika.');
    }

}
