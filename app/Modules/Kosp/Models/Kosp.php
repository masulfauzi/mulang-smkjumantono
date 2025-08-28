<?php

namespace App\Modules\Kosp\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\TahunAjaran\Models\TahunAjaran;


class Kosp extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'kosp';
	protected $fillable   = ['*'];	

	public function tahunAjaran(){
		return $this->belongsTo(TahunAjaran::class,"id_tahun_ajaran","id");
	}

}
