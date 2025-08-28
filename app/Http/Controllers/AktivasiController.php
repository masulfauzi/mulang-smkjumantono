<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Siswa\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Modules\Users\Models\Users;
use Illuminate\Support\Str;
use App\Modules\UserRole\Models\UserRole;
use Illuminate\Support\Facades\DB;


class AktivasiController extends Controller
{
    public function index()
    {
        return view('aktivasi.index');
    }

    public function store(Request $request)
    {
        $data_siswa = Siswa::cek_aktivasi_siswa($request);

        if ($data_siswa->count() > 0) {
            return redirect()->route('aktivasi.input', $data_siswa->first()->id)->with('message_success', 'Silahkan Isi Form di Bawah Ini.');
        } else {
            return redirect()->route('aktivasi')->with('message_danger', "Data Tidak Ditemukan");
        }
    }

    public function input_data(Request $request, $id_siswa)
    {
        $data_siswa = Siswa::find($id_siswa);

        $data['siswa'] = $data_siswa;


        return view('aktivasi.aktivasi', $data);
    }

    public function registrasi(Request $request)
    {
        $this->validate($request, [
            'username'  => 'required|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'no_hp'  => 'required|min:8|regex:/^(62)8[1-9][0-9]{6,10}$/'
        ]);

        $data_siswa = Siswa::find($request->id);
        $data_siswa->no_hp = $request->no_hp;
        $data_siswa->save();

        $data_user = [
            'id'            => Str::uuid(),
            'name'          => $request->name,
            'username'      => $request->username,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'identitas'     => $request->nik,
            'created_at'    => Carbon::now()->toDateTimeString(),
            'ids'           => $request->password
        ];

        $data_role = [
            'id'        => Str::uuid(),
            'id_user'   => $data_user['id'],
            'id_role'   => 'ce70ee2f-b43b-432b-b71c-30d073a4ba23'
        ];

        Users::insert($data_user);
        UserRole::insert($data_role);

        return redirect()->route('login')->with('message_danger', 'Registrasi Berhasil, Silahkan Login!');
    }

    public function radius()
    {
        $data = DB::table('users')
            ->whereNull('is_singkron')
            ->get();

        return json_encode($data);
    }
}
