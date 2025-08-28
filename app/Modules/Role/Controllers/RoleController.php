<?php
namespace App\Modules\Role\Controllers;

use Form;
use Illuminate\Http\Request;
use App\Modules\Menu\Models\Menu;
use App\Modules\Role\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Privilege\Models\Privilege;

class RoleController extends Controller
{
	protected $title = "Role";
	public function index(Request $request)
	{
		$query = Role::query();
		if($request->has('search')){
			$search = $request->get('search');
			$query->where('role', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10);
		return view('Role::role', array_merge($data, ['title' => $this->title]));
	}

	public function create()
	{	
		$data['forms'] = array(
			'role' => ['Role', Form::text("role", old("role"), ["class" => "form-control","placeholder" => ""]) ],
		);
		return view('Role::role_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'role' => 'required',
		]);

		$rmax = Role::max('level');
		$max = $rmax == null ? 0 : $rmax + 1;

		$role = new Role();
		$role->role = $request->input("role");
		$role->level = $max;
		$role->created_by = Auth::id();
		$role->save();

		$menus = Menu::where('level', 1)->get();
		foreach ($menus as $key => $value) {
			$priv = new Privilege();
			$priv->id_menu = $value->id;
			$priv->id_role = $role->id;
			$priv->create = 0;
			$priv->read = 0;
			$priv->show = 0;
			$priv->update = 0;
			$priv->delete = 0;
			$priv->show_menu = 0;
			$priv->save();
		}

		return redirect()->route('role.index')->with('message_success', 'Role berhasil ditambahkan!');
	}

	public function edit(Role $role)
	{
		$data['role'] = $role;
		$data['forms'] = array(
			'role' => ['Role', Form::text("role", $role->role, ["class" => "form-control","placeholder" => "", "id" => "role"]) ],
		);

		return view('Role::role_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'role' => 'required',
		]);
		
		$role = Role::find($id);
		$role->role = $request->input("role");
		$role->updated_by = Auth::id();
		$role->save();

		$menus = Menu::where('level', 1)->get();
		foreach ($menus as $key => $value) {
			$priv = Privilege::where('id_menu', $value->id)->where('id_role', $value->id)->first();
			if($priv == null){
				$priv = new Privilege();
				$priv->id_menu = $value->id;
				$priv->id_role = $role->id;
				$priv->create = 0;
				$priv->read = 0;
				$priv->show = 0;
				$priv->update = 0;
				$priv->delete = 0;
				$priv->show_menu = 0;
				$priv->save();
			}
		}

		return redirect()->route('role.index')->with('message_success', 'Role berhasil diubah!');
	}

	public function destroy($id)
	{
		$role = Role::find($id);
		$role->deleted_by = Auth::id();
		$role->save();
		$role->delete();

		return back()->with('message_success', 'Role berhasil dihapus!');
	}

}
