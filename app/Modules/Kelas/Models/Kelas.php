<?php

namespace App\Modules\Kelas\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Ruang\Models\Ruang;


class Kelas extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'kelas';
	protected $fillable   = ['*'];	

	public function tingkat(){
		return $this->belongsTo(Tingkat::class,"id_tingkat","id");
	}
public function jurusan(){
		return $this->belongsTo(Jurusan::class,"id_jurusan","id");
	}
	public function ruang()
	{
		return $this->belongsTo(Ruang::class,"id_ruang","id");
	}

}
