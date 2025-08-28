<?php

namespace App\Jobs;

use App\Modules\Guru\Models\Guru;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\PenilaianAkhirSemester\Models\PenilaianAkhirSemester;
use App\Modules\Pesan\Models\Pesan;
use App\Modules\Semester\Models\Semester;
use App\Modules\Tingkat\Models\Tingkat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CekPerangkatSumatif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $semester_aktif = Semester::get_semester_aktif();

        // dd($semester_aktif->id);

        $query = DB::table('jam_mengajar as a')
            ->select('a.*', 'c.mapel', 'e.tingkat', 'b.nama')
            ->join('guru as b', 'a.id_guru', '=', 'b.id')
            ->join('mapel as c', 'a.id_mapel', '=', 'c.id')
            ->join('kelas as d', 'a.id_kelas', '=', 'd.id')
            ->join('tingkat as e', 'd.id_tingkat', '=', 'e.id')
            ->where('a.id_semester', $semester_aktif->id)
            ->where('b.is_aktif', '1')
            ->whereNull('b.deleted_at')
            ->groupBy('e.id', 'c.id', 'b.id')
            ->orderBy('b.nama')
            ->orderBy('e.tingkat')
            ->orderBy('c.mapel')
            ->get();

        foreach ($query as $data) {
            // dd($data);
            $kelas = Kelas::find($data->id_kelas);

            $perangkat = PenilaianAkhirSemester::whereIdGuru($data->id_guru)
                ->whereIdMapel($data->id_mapel)
                ->whereIdTingkat($kelas->id_tingkat)
                ->whereIdSemester($semester_aktif->id)
                ->first();

            if (!$perangkat) {
                $guru = Guru::find($data->id_guru);
                $mapel = Mapel::find($data->id_mapel);
                $tingkat = Tingkat::find($kelas->id_tingkat);

                $pesan = new Pesan();
                $pesan->nomor = $guru->no_hp;
                $pesan->isi_pesan = "*PENGINGAT*
                                    Anda belum mengunggah Perangkat Asesmen Sumatif untuk:
                                    Mapel: *$mapel->mapel*
                                    Tingkat: *$tingkat->tingkat*
                                    Segera unggah sebelum tanggal 16 November 2024.";
                $pesan->status = 0;
                $pesan->created_by = "cronjob";
                $pesan->save();

                // dd($pesan);
            }
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
