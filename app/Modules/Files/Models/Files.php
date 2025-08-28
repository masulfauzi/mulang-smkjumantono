<?php

namespace App\Modules\Files\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Jenis\Models\Jenis;


class Files extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'files';
	protected $fillable   = ['*'];	

	public function jenis(){
		return $this->belongsTo(Jenis::class,"id_jenis","id");
	}

}
