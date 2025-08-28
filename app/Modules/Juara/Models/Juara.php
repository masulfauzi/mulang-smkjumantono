<?php

namespace App\Modules\Juara\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\TingkatJuara\Models\TingkatJuara;


class Juara extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'juara';
	protected $fillable   = ['*'];	

	public function tingkatJuara(){
		return $this->belongsTo(TingkatJuara::class,"id_tingkat_juara","id");
	}

}
