<?php

namespace App\Modules\JurnalTu\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\StatusPekerjaan\Models\StatusPekerjaan;
use App\Modules\Karyawan\Models\Karyawan;


class JurnalTu extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'jurnal_tu';
	protected $fillable   = ['*'];	

	public function statusPekerjaan(){
		return $this->belongsTo(StatusPekerjaan::class,"id_status_pekerjaan","id");
	}
public function karyawan(){
		return $this->belongsTo(Karyawan::class,"id_karyawan","id");
	}

}
