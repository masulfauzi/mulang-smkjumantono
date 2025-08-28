<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Semester\Models\Semester;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Presensi\Models\Presensi;
use App\Modules\Jadwal\Models\Jadwal;


class DashboardController extends Controller
{
    public function index()
    {
        $data['jml_siswa']      = Pesertadidik::query()->where('id_semester', get_semester('active_semester_id'))->get()->count();
        $data['siswa_hadir']    = Presensi::get_kehadiran_siswa('H', get_semester('active_semester_id'), date('Y-m-d'))->count();
        $data['siswa_sakit']    = Presensi::get_kehadiran_siswa('S', get_semester('active_semester_id'), date('Y-m-d'))->count();
        $data['siswa_ijin']     = Presensi::get_kehadiran_siswa('I', get_semester('active_semester_id'), date('Y-m-d'))->count();
        $data['siswa_alfa']     = Presensi::get_kehadiran_siswa('A', get_semester('active_semester_id'), date('Y-m-d'))->count();
        $data['siswa_magang']   = Presensi::get_siswa_magang(get_semester('active_semester_id'))->count();
        $data['jml_jadwal']     = Jadwal::get_jadwal_today()->count();
        $data['jadwal_terlaksana']     = Jadwal::get_jadwal_terlaksana_today()->count();

        return view('dashboard', $data);
    }

    public function changeRole($id_role)
    {
        $user = Auth::user();

        
        // get user's role
        $roles = Permission::getRole($user->id);
        if($roles->count() == 0) abort(403);
        $active_role = $roles->where('id', $id_role)->first()->only(['id', 'role']);
        // dd($active_role);
        // get user's menu
        $menus = Permission::getMenu($active_role);
        
        // get user's privilege
        $privileges = Permission::getPrivilege($active_role);
        $privileges = $privileges->mapWithKeys(function ($item, $key) {
            return [$item['module'] => $item->only(['create', 'read', 'show', 'update', 'delete', 'show_menu'])];
        });
        
        // store to session
        session(['menus' => $menus]);
        session(['roles' => $roles->pluck('role', 'id')->all()]);
        session(['privileges' => $privileges->all()]);
        session(['active_role' => $active_role]);
        // die("sampe sini");

        return redirect()->route('dashboard')->with('message_success', 'Berhasil memperbarui role/session sebagai '.$active_role['role']);
    }

    public function changeSemester($id_semester)
    {
        $semester = Semester::all();
        $semester_aktif = $semester->where('id', $id_semester)->first()->only(['id', 'semester']);

        session(['active_semester' => $semester_aktif]);

        return redirect()->back()->with('message_success', 'Berhasil memperbarui semester sebagai '.$semester_aktif['semester']);
    }

    public function forceLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
