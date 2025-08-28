<?php

namespace App\Modules\Students\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Jeniskelamin\Models\Jeniskelamin;
use App\Modules\Agama\Models\Agama;


class Students extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'students';
	protected $fillable   = ['*'];	

	public function jeniskelamin(){
		return $this->belongsTo(Jeniskelamin::class,"id_jeniskelamin","id");
	}
public function agama(){
		return $this->belongsTo(Agama::class,"id_agama","id");
	}

}
