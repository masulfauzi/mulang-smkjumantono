<?php
namespace App\Helpers;

use App\Modules\Menu\Models\Menu;
use App\Modules\Role\Models\Role;
use App\Modules\Users\Models\Users;
use Illuminate\Support\Facades\Route;
use App\Modules\Privilege\Models\Privilege;

/**
 * Permission created by @abianbiya on 20 Jun 2022
 */
class Permission 
{
	public static function can($route)
	{
		$elm = explode('.', $route);
		$menu = reset($elm);
		$action = end($elm);

		$exceptions = config('laralag.module_exception');
		if(in_array($menu, $exceptions)) return true;
		
		$action = config('laralag.translate_action')[$action];
		$privileges = session('privileges');
		return $privileges[$menu][$action];
	}

	public static function getMenu($id_role)
	{
		$menus = Role::with('menu')->where('id',$id_role)->first();

		$groups = Menu::where('level', 0)->where('is_tampil', 1)->orderBy('urutan')->get(['menu.id', 'icon', 'menu', 'routing', 'level', 'urutan', 'parent_id'])->all();
		$menus = $menus->menu()->orderBy('urutan')->get(['menu.id', 'icon', 'menu', 'routing', 'level', 'urutan', 'parent_id'])->all();

		return array_merge($groups, $menus);
	}

	public static function getRole($id_user)
	{
		return Users::with('roleuser')->find($id_user)->roleuser()->orderByDesc('level')->get();
	}

	public static function getPrivilege($id_role)
	{
		return Privilege::leftJoin('menu as m', 'm.id', 'id_menu')->where('id_role', $id_role)->get(['module', 'create', 'read', 'show', 'update', 'delete', 'show_menu']);
	}
}
