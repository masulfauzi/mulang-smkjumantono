<?php

namespace App\Modules\Prestasi\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Juara\Models\Juara;
use App\Modules\Siswa\Models\Siswa;


class Prestasi extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'prestasi';
	protected $fillable   = ['*'];

	public function juara()
	{
		return $this->belongsTo(Juara::class, "id_juara", "id");
	}
	public function siswa()
	{
		return $this->belongsTo(Siswa::class, "id_siswa", "id");
	}

	public static function cek_prestasi($id_siswa)
	{
		return Prestasi::where('id_siswa', '=', $id_siswa)
			->where('is_verif', '=', '0')
			->get();
	}
}
