<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function proses(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $kredensial = $request->only('email','password');
    
        if(Auth::attempt($kredensial)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->level == 1){
                return redirect()->intended('admin');
            }
            elseif($user->level == 2){
                return redirect()->intended('petugas');
            }
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'Username atau password Salah',
        ])->onlyInput('email');
    }
    public function createuser(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->level = $request->input('level');
        $user->save();
        return redirect('/userview')->with('status', 'User Berhasiltambahkan');
    }
    public function logout(Request $request): RedirectResponse
{
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/login');
}
}