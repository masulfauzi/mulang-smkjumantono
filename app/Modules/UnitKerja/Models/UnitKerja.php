<?php

namespace App\Modules\UnitKerja\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UnitKerja extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'unit_kerja';
	protected $fillable   = ['*'];	

	public function indukunit(){
		return $this->belongsTo(UnitKerja::class,"induk","id");
	}
}
