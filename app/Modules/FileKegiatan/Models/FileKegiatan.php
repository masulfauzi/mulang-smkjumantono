<?php

namespace App\Modules\FileKegiatan\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Kegiatan\Models\Kegiatan;


class FileKegiatan extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'file_kegiatan';
	protected $fillable   = ['*'];	

	public function kegiatan(){
		return $this->belongsTo(Kegiatan::class,"id_kegiatan","id");
	}

}
