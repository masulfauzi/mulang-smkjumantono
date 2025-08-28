<?php

namespace App\Modules\PenilaianAkhirSemester\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Guru\Models\Guru;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\Semester\Models\Semester;


class PenilaianAkhirSemester extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'penilaian_akhir_semester';
	protected $fillable   = ['*'];

	public function guru()
	{
		return $this->belongsTo(Guru::class, "id_guru", "id");
	}
	public function mapel()
	{
		return $this->belongsTo(Mapel::class, "id_mapel", "id");
	}
	public function tingkat()
	{
		return $this->belongsTo(Tingkat::class, "id_tingkat", "id");
	}
	public function semester()
	{
		return $this->belongsTo(Semester::class, "id_semester", "id");
	}

	public static function get_perangkat($data, $jenis = NULL)
	{
		// dd($jenis);

		$kelas = Kelas::find($data->id_kelas);

		return PenilaianAkhirSemester::whereIdGuru($data->id_guru)
			->whereIdMapel($data->id_mapel)
			->whereIdTingkat($kelas->id_tingkat)
			->whereIdSemester($data->id_semester)
			->first();
	}
}
