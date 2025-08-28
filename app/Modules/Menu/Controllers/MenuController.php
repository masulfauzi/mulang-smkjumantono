<?php
namespace App\Modules\Menu\Controllers;

use App\Helpers\Logger;
use Form;
use Illuminate\Http\Request;
use App\Modules\Menu\Models\Menu;
use App\Modules\Role\Models\Role;

use App\Http\Controllers\Controller;
use App\Modules\Log\Models\Log;
use Illuminate\Support\Facades\Auth;
use App\Modules\Privilege\Models\Privilege;

class MenuController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Menu";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Menu::with('menuref');
		if($request->has('search')){
			$search = $request->get('search');
			$query->where('menu', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10);

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Menu::menu', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$menus = Menu::where('level', '<', 2)->get()->pluck('menu', 'id');
		$roles = Role::all()->pluck('role', 'id');
		$data['forms'] = array(
			'menu' => ['Menu', Form::text("menu", old("menu"), ["class" => "form-control","placeholder" => "Nama Menunya"]) ],
			'icon' => ['Icon', Form::text("icon", old("icon"), ["class" => "form-control", "placeholder" => "Icon menu, ex: fa-book"]) ],
			'is_tampil' => ['Tampil?', Form::select("is_tampil", ["1" => "Ya", "0" => "Tidak"], old("is_tampil"), ["class" => "form-control"]) ],
			'level' => ['Level Hirarki', Form::select("level", ["0" => "Group Menu", "1" => "Menu", "2" => "Submenu"], null, ["class" => "form-control select2","placeholder" => "-- Pilih Level Menu"]) ],
			'parent_id' => ['Parent Id', Form::select("parent_id", $menus, null, ["class" => "form-control select2","placeholder" => "-- Pilih Parent Menu"]) ],
			'module' => ['Module', Form::text("module", old("module"), ["class" => "form-control","placeholder" => "Ex: user"]) ],
			'routing' => ['Routing', Form::text("routing", old("routing"), ["class" => "form-control","placeholder" => "Ex: user.index"]) ],
			'urutan' => ['Urutan', Form::number("urutan", old("urutan"), ["class" => "form-control","placeholder" => "n"]) ],
			'roles' => ['Role', Form::select("roles[]", $roles, null, ["class" => "form-control multi-select2", "placeholder" => "Role ", "required" => "required"])],
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Menu::menu_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'icon' => 'required',
			'is_tampil' => 'required',
			'level' => 'required',
			'menu' => 'required',
			'module' => 'required',
			'parent_id' => 'required',
			'routing' => 'required',
			'urutan' => 'required',
			'roles' => 'required|array',
			
		]);

		$menu = new Menu();
		$menu->icon = $request->input("icon");
		$menu->is_tampil = $request->input("is_tampil");
		$menu->level = $request->input("level");
		$menu->menu = $request->input("menu");
		$menu->module = $request->input("module");
		$menu->parent_id = $request->input("parent_id");
		$menu->routing = $request->input("routing");
		$menu->urutan = $request->input("urutan");
		$menu->created_by = Auth::id();
		$menu->save();

		$roles = Role::all();
		foreach ($roles as $key => $value) {
			$def = in_array($value->id, $request->get('roles')) ? 1 : 0;

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

		$this->log($request, 'membuat '.$this->title.' baru: '.$menu->menu, ['menu.id' => $menu->id]);
		return redirect()->route('menu.index')->with('message_success', 'Menu berhasil ditambahkan!');
	}

	public function edit(Request $request, Menu $menu)
	{
		$data['menu'] = $menu;
		$roles = Role::all()->pluck('role', 'id');
		$selected = Privilege::where('id_menu', $menu->id)->where('show_menu', 1)->get()->pluck('id_role');
		$menus = Menu::where('level', '<', 2)->get()->pluck('menu', 'id');
		$data['selecteds'] = $selected;
		$data['forms'] = array(
			'menu' => ['Menu', Form::text("menu", $menu->menu, ["class" => "form-control","placeholder" => "", "id" => "menu"]) ],
			'module' => ['Module', Form::text("module", $menu->module, ["class" => "form-control","placeholder" => "", "id" => "module"]) ],
			'icon' => ['Icon', Form::text("icon", $menu->icon, ["class" => "form-control","placeholder" => "", "id" => "icon"]) ],
			'is_tampil' => ['Tampilkan Menu?', Form::select("is_tampil", ["1" => "Ya", "0" => "Tidak"], $menu->is_tampil, ["class" => "form-control", "id" => "is_tampil"]) ],
			'level' => ['Level Hirarki', Form::select("level", ["0" => "Group Menu", "1" => "Menu", "2" => "Submenu"], $menu->level, ["class" => "form-control select2", "placeholder" => "-- Pilih Level Menu"]) ],
			'parent_id' => ['Parent Id', Form::select("parent_id", $menus, $menu->parent_id, ["class" => "form-control select2","placeholder" => "", "id" => "parent_id"]) ],
			'routing' => ['Routing', Form::text("routing", $menu->routing, ["class" => "form-control","placeholder" => "", "id" => "routing"]) ],
			'urutan' => ['Urutan', Form::text("urutan", $menu->urutan, ["class" => "form-control","placeholder" => "n", "id" => "urutan"]) ],
			'roles' => ['Role', Form::select("roles[]", $roles, null, ["class" => "form-control multi-select2", "placeholder" => "Role ", "required" => "required"])],
		);

		$this->log($request, 'membuka form edit '.$this->title.' '.$menu->menu, ['menu.id' => $menu->id]);
		return view('Menu::menu_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'icon' => 'required',
			'is_tampil' => 'required',
			'level' => 'required',
			'menu' => 'required',
			'module' => 'required',
			'parent_id' => 'required',
			'routing' => 'required',
			'urutan' => 'required',
			
		]);
		
		$menu = Menu::find($id);
		$menuorg = $menu->toArray();
		$menu->icon = $request->input("icon");
		$menu->is_tampil = $request->input("is_tampil");
		$menu->level = $request->input("level");
		$menu->menu = $request->input("menu");
		$menu->module = $request->input("module");
		$menu->parent_id = $request->input("parent_id");
		$menu->routing = $request->input("routing");
		$menu->urutan = $request->input("urutan");
		$menu->updated_by = Auth::id();
		$menu->save();

		$roles = Role::all();
		foreach ($roles as $key => $value) {
			$def = in_array($value->id, $request->get('roles')) ? 1 : 0;

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

		$this->log($request, 'mengedit '.$this->title.' '.$menu->menu, ['menu.id' => $menu->id], ['from' => $menuorg, 'to' => $menu]);
		return redirect()->route('menu.index')->with('message_success', 'Menu berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$menu = Menu::find($id);
		$menu->deleted_by = Auth::id();
		$menu->save();
		$menu->delete();

		$this->log($request, 'menghapus '.$this->title.' '.$menu->menu, ['menu.id' => $menu->id]);
		return back()->with('message_success', 'Menu berhasil dihapus!');
	}

}
