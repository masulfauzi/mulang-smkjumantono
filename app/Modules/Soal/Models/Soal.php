<?php

namespace App\Modules\Soal\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Ujiansekolah\Models\Ujiansekolah;
use App\Modules\Jenissoal\Models\Jenissoal;


class Soal extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'soal';
	protected $fillable   = ['*'];	

	public function ujiansekolah(){
		return $this->belongsTo(Ujiansekolah::class,"id_ujiansekolah","id");
	}
public function jenissoal(){
		return $this->belongsTo(Jenissoal::class,"id_jenissoal","id");
	}

	public static function cek_soal($id_ujian, $id_jenissoal, $no_soal)
	{
		return DB::table('soal')
					->where('id_ujiansekolah', $id_ujian)
					->where('id_jenissoal', $id_jenissoal)
					->where('no_soal', $no_soal)
					->get();
	}

	public static function get_soal_terinput($id_ujian, $id_jenis_soal)
	{
		
	}

}
