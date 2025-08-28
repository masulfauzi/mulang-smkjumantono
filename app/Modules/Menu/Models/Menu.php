<?php

namespace App\Modules\Menu\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Str;
use App\Modules\Role\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Privilege\Models\Privilege;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'menu';
	protected $fillable   = ['*'];	

	public function menuref()
	{
		return $this->hasOne($this, 'parent_id', 'id');
	}

	public static function createByModule($module)
	{
		$menu = new Menu();
		$menu->icon = 'fa-folder';
		$menu->is_tampil = 1;
		$menu->level = 1;
		$menu->menu = Str::headline($module);
		$menu->module = Str::lower($module);
		$menu->parent_id = config('laralag.dict.menu_referensi');
		$menu->routing = $menu->module.".index";
		$menu->urutan = rand(1,9)*10;
		$menu->created_by = 'Generator';
		$menu->save();

		$roles = Role::all();
		$idsuper = $roles->where('level', 1)->first()->id;
		
		foreach ($roles as $key => $value) {
			$def = $value->id == $idsuper ? 1 : 0;

			$priv = new Privilege();
			$priv->id_menu = $menu->id;
			$priv->id_role = $value->id;
			$priv->create = $def;
			$priv->read = $def;
			$priv->show = $def;
			$priv->update = $def;
			$priv->delete = $def;
			$priv->show_menu = $def;
			$priv->save();
		}
	}
}
