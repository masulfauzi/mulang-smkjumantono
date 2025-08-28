<?php

namespace App\Modules\PengembanganDiri\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\JenisPengembangan\Models\JenisPengembangan;
use App\Modules\Guru\Models\Guru;


class PengembanganDiri extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'pengembangan_diri';
	protected $fillable   = ['*'];	

	public function jenisPengembangan(){
		return $this->belongsTo(JenisPengembangan::class,"id_jenis_pengembangan","id");
	}
public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}

}
