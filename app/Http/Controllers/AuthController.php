<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function index()
    {
        $allmember = User::all()->whereIn('hak_akses', ['member', 'kasir', 'admin']);
        $member = User::all()->where('hak_akses', 'member');
        return view('pages.users', compact('allmember', 'member'));
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function postlogin(Request $request)
    {
        // ...validation...

        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function register()
    {
        return view('register');
    }

    public function postregister(Request $request)
    {
        $role = $request->role == null ? 'member' : $request->role;
        DB::table('users')->insert([
            'username' => $request->username,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'hak_akses' => $role,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/users');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
