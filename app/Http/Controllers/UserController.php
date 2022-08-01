<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // //Resgister
    // public function register ()
    // {
    //     $data['title'] = 'Register';
    //     return view('userauth/register', $data);
    // }

    // public function register_action (Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'username' => 'required|unique:tb_user',
    //         'password' => 'required',
    //         'konfirmasi_password' => 'required|same:password',
    //     ]);
    //     $user = new User([
    //         'nama' => $request->nama,
    //         'username' => $request->username,
    //         'password' => Hash::make($request->username),

    //     ]);
    //     $user->save();
    //     return redirect()->route('login')->with('success','Registrasi Sukses, Silahkan Login!');
    // }

    public function login ()
    {
        $data['title'] = 'Login';
        return view('userauth/login', $data);
    }

    public function login_action (Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if(Auth::attempt(['username' => $request->username,'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors(['password' => 'Wrong username or password!']);
    }

    public function profil ()
    {
        $data['title'] = 'Update Profil';
        return view('user/profil', $data);
    }

    public function profil_update (Request $request)
    {
        $request->validate([
            'nama' => 'reqired',
            'password_lama' => 'required|current_password',
            'password_baru' => 'required',
            'konfirmasi_password_baru'=>'required|same:password_baru',

        ]);
        $user = User::find(Auth::id());
        $user->$request->nama;
        $user->password = Hash::make($request->password_baru);
        $user->save();

        $request->session()->regenerate();
        return back()->with('success', 'Berhasil merubah password!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('login');
    }


}
