<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'User MAnager';
        return view('user.index', $data);
    }
    public function data()
    {
        $user = User::isNotAdmin()->orderBy('id_user', 'desc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`' . route('user.update', $user->id_user) . '`)" class="btn btn-info "><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`' . route('user.destroy', $user->id_user) . '`)" class="btn btn-danger "><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->level = 2;
        $user->foto = '/img/avatar5.png';
        $user->save();

        return response()->json('Data berhasil disimpan', 200);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find( $id);
        $user->nama = $request->nama;
        $user->username = $request->username;
        if ($request->has('password') && $request->password != "")
            $user->password = bcrypt($request->password);
        $user->update();

        return response()->json('Data berhasil disimpan', 200);
    }
/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find( $id)->delete();

        return response(null, 204);
    }

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

    public function login()
    {
        $data['title'] = 'Login';
        return view('userauth/login', $data);
    }

    public function login_action(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors(['password' => 'Wrong username or password!']);
    }

    public function profil()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $user->nama = $request->nama;
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->password_lama, $user->password)) {
                if ($request->password == $request->konfirmasi_password) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "/img/$nama";
        }

        $user->update();

        return response()->json($user, 200);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('login');
    }
}
