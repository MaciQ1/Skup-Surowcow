<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index($id = null)
    {
        // Użytkownik jest zalogowany i ma rolę admina
        if (Auth::check() && Auth::user()->role == 'admin') {

            if ($id) {
                $user = User::find($id);

                if (!$user) {
                    abort(403);
                }

                return view('admin.users.index', ['user' => $user]);
            }

            $users = User::all();
            return view('admin.users.index', ['users' => $users]);
        } else {
            // Użytkownik nie jest adminem
            abort(403);
        }
    }


    public function show($id)
    {

        if (Auth::check() && Auth::id() == $id) {
            $user = User::find($id);
            if (!$user) {
                abort(403);
            }

            return view('user.profile.show', ['user' => $user]);
        } else {
            abort(403);
        }
    }


    public function panel($id)
    {
        if (Auth::check() && Auth::id() == $id) {
            $user = User::find($id);
            if (!$user) {
                abort(403);
            }

            return view('user.panel', ['user' => $user]);
        } else {
            abort(403);
        }
    }

    public function create($id = null)
    {
        // Użytkownik jest zalogowany i ma rolę admina
        if (Auth::check() && Auth::user()->role == 'admin') {

            if ($id) {
                $user = User::find($id);
                // Użytkownik nie istnieje
                if (!$user) {
                    abort(403);
                }

                return view('admin.users.create', ['user' => $user]);
            }

            return view('admin.users.create');
        } else {
            // Użytkownik nie jest adminem
            abort(403);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|integer|digits:9',
        ]);

        $user = new User();
        $user->login = $request->input('login');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone_number');
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Użytkownik został dodany.');
    }

    public function edit($id = null)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                if ($id) {
                    $userToEdit = User::find($id);
                    if (!$userToEdit) {
                        abort(403, 'User not found');
                    }
                    return view('admin.users.edit', ['user' => $userToEdit]);
                }
            } else {
                if ($user->id != $id) {
                    abort(403, 'Unauthorized access');
                }
                return view('user.profile.edit', ['user' => $user]);
            }
        }

        abort(403, 'Unauthorized access');
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Gate::authorize('update', $user);

        $request->validate([
            'login' => 'required|string|max:255|unique:users,login,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:1',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|integer|digits:9',
        ]);

        $input = $request->all();

        if (empty($input['password'])) {
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }

        if (Auth::user()->role === 'admin') {
            $user->update($input);
            return redirect()->route('admin.users.index')->with('success', 'Zaktualizowano użytkownika.');
        }
        if (Auth::check() && Auth::id() == $id) {
            $user->update($input);
            return redirect()->route('user.profile.show', $id)->with('success', 'Zaktualizowano użytkownika.');
        }
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            $loggedUser = Auth::user();

            // Użytkownik próbuje usunąć swoje własne konto
            if ($loggedUser->id === $id) {
                return redirect()->route('admin.users.index')->with('error', 'Nie możesz usunąć swojego własnego konta.');
            }

            $user = User::findOrFail($id);

            // Użytkownik próbuje usunąć konto innego admina
            if ($user->role === 'admin') {
                return redirect()->route('admin.users.index')->with('error', 'Nie możesz usunąć konta admina.');
            }

            // Weryfikacja uprawnień użytkownika
            if ($loggedUser->role == 'admin' || $loggedUser->id == $user->id) {
                $user->delete();
                return redirect()->route('admin.users.index')->with('success', 'Usunięto użytkownika.');
            } else {
                abort(403);
            }
        }

        abort(403);
    }
}
