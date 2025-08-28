<?php

namespace App\Http\Controllers;

use App\Helpers\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Modules\Semester\Models\Semester;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Presensi\Models\Presensi;
use App\Modules\Jadwal\Models\Jadwal;
use App\Modules\Snmptn\Models\Snmptn;


class SnbpController extends Controller
{
    public function index(Request $request)
    {
        // return view('snbp');
        return $request->userAgent();
    }

    public function cek_siswa(Request $request)
    {
        $data['data'] = Snmptn::get_detail_snmptn_by_nisn($request->get('nisn'));
        $data['kuota'] = Snmptn::get_peringkat($data['data']->id_jurusan);

        return view('snbp_eligible', $data);
    }

    
}
