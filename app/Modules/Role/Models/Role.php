<?php

namespace App\Modules\Role\Models;

use App\Helpers\UsesUuid;
use App\Modules\Menu\Models\Menu;
use Illuminate\Support\Facades\DB;
use App\Modules\Users\Models\Users;
use Illuminate\Database\Eloquent\Model;
use App\Modules\UserRole\Models\UserRole;
use App\Modules\Privilege\Models\Privilege;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'role';
	protected $fillable   = ['*'];	

	public function user()
	{
		return $this->hasManyThrough(Users::class, UserRole::class, 'id_user', 'id' , 'id', 'id_role');
	}

	public function menu()
	{
		return $this->hasManyThrough(Menu::class, Privilege::class, 'id_role', 'id' , 'id', 'id_menu')->where('menu.is_tampil', 1)->where('show_menu', 1);
	}
}
