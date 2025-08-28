<?php

namespace App\Listeners;

use App\Helpers\Permission;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Guru\Models\Guru;
use App\Modules\Karyawan\Models\Karyawan;
use App\Modules\Semester\Models\Semester;
use App\Modules\Siswa\Models\Siswa;

class LogSuccessfullLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        try {
            // get user's role
            $roles = Permission::getRole($user->id);
            if($roles->count() == 0) $this->logout();
            $active_role = $roles->first()->only(['id', 'role']);

            // get user's menu
            $menus = Permission::getMenu($active_role);

            // get user's privilege
            $privileges = Permission::getPrivilege($active_role);
            $privileges = $privileges->mapWithKeys(function ($item, $key) {
                                return [$item['module'] => $item->only(['create', 'read', 'show', 'update', 'delete', 'show_menu'])];
                            });

            //get all semester
            $semester = Semester::orderBy('urutan')->get();
            // dd($semester);

            //get session semester aktif
            $semester_aktif = collect(Semester::get_semester_aktif());
            // dd($semester_aktif);
            session(['active_semester' => $semester_aktif]);
            // dd(session('active_semester'));

            

            // store to session
            session(['menus' => $menus]);
            session(['roles' => $roles->pluck('role', 'id')->all()]);
            session(['privileges' => $privileges->all()]);
            session(['active_role' => $active_role]);  
            session(['semester' => $semester->pluck('semester', 'id')]);  

            //session custom
            //get session id_guru
            if($guru = Guru::get_id_guru_by_id_user(Auth::user()->id)->first())
            {
                session(['id_guru' => $guru->id_guru]);
            }

            //get session id_karyawan
            if($karyawan = Karyawan::get_id_karyawan_by_id_user(Auth::user()->id)->first())
            {
                session(['id_karyawan' => $karyawan->id_karyawan]);
            }

            if($siswa = Siswa::get_siswa_by_id_user(Auth::user()->id)->first())
            {
                session(['id_siswa' => $siswa->id_siswa]);
            }
            

        } catch (\Throwable $th) {
            $this->logout();
        }
        
    }

    public function logout()
    {
        $request = request();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
