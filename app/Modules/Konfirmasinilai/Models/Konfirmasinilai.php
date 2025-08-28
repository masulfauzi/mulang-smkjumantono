<?php

namespace App\Modules\Konfirmasinilai\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Siswa\Models\Siswa;
use App\Modules\Semester\Models\Semester;


class Konfirmasinilai extends Model
{
	// use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'konfirmasinilai';
	protected $fillable   = ['*'];

	public function siswa()
	{
		return $this->belongsTo(Siswa::class, "id_siswa", "id");
	}
	public function semester()
	{
		return $this->belongsTo(Semester::class, "id_semester", "id");
	}

	public static function get_konfirmasi($id_siswa)
	{
		return Konfirmasinilai::where('id_siswa', '=', $id_siswa)
			->where('is_verif', '=', '0')
			->get();
	}
}
