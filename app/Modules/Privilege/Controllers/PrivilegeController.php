<?php
namespace App\Modules\Privilege\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Privilege\Models\Privilege;
use App\Modules\Menu\Models\Menu;
use App\Modules\Role\Models\Role;

use Form;

class PrivilegeController extends Controller
{
	protected $title = "Privilege";
	public function index(Request $request)
	{
		$query = Privilege::query();
		if($request->has('id_role')){
			$search = $request->get('id_role');
			$query->where('id_role', $search);
			
			$data['role'] = Role::find($search);
		}else{
			abort(403);
		}
		$data['data'] = $query->paginate(100)->withQueryString();
		return view('Privilege::privilege', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_menu = Menu::whereIn('level', [1,2])->orderBy('parent_id')->orderBy('urutan')->get()->pluck('menu','id');
		
		$data['forms'] = array(
			'id_menu' => ['Menu', Form::select("id_menu", $ref_menu, null, ["class" => "form-control select2", "placeholder" => "Pilih Menu"]) ],
			'create' => ['Create Access', Form::select("create", ["1" => "Grant", "0" => "Deny"], null, ["class" => "form-control select2", "placeholder" => "Create Data"]) ],
			'read' => ['Read Access', Form::select("read", ["1" => "Grant", "0" => "Deny"], null, ["class" => "form-control select2","placeholder" => "Read Data"]) ],
			'show' => ['Detail Access', Form::select("show", ["1" => "Grant", "0" => "Deny"], null, ["class" => "form-control select2","placeholder" => "Detail Data"]) ],
			'update' => ['Update Access', Form::select("update", ["1" => "Grant", "0" => "Deny"], null, ["class" => "form-control select2","placeholder" => "Update Data"]) ],
			'delete' => ['Delete Access', Form::select("delete", ["1" => "Grant", "0" => "Deny"], null, ["class" => "form-control select2", "placeholder" => "Delete Data"]) ],
			'show_menu' => ['Show Menu', Form::select("show_menu", ["1" => "Grant", "0" => "Deny"], null, ["class" => "form-control select2","placeholder" => "Is menu shown to the role"]) ],
		);

		$data['role'] = Role::find($request->get('id_role'));
		return view('Privilege::privilege_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'create' => 'required',
			'delete' => 'required',
			'id_menu' => 'required',
			'id_role' => 'required',
			'read' => 'required',
			'show_menu' => 'required',
			'update' => 'required',
		]);

		$isthere = Privilege::where('id_role', $request->get('id_role'))->where('id_menu', $request->get('id_menu'))->count();
		if($isthere){
			return redirect()->route('privilege.index', ['id_role' => $request->get('id_role')])->with('message_danger', 'Privilege untuk role dan menu tersebut sudah ada, silakan edit!');
		}
		$privilege = new Privilege();
		$privilege->create = $request->input("create");
		$privilege->delete = $request->input("delete");
		$privilege->id_menu = $request->input("id_menu");
		$privilege->id_role = $request->input("id_role");
		$privilege->read = $request->input("read");
		$privilege->show_menu = $request->input("show_menu");
		$privilege->update = $request->input("update");
		$privilege->created_by = Auth::id();
		$privilege->save();

		return redirect()->route('privilege.index', ['id_role' => $request->get('id_role')])->with('message_success', 'Privilege berhasil ditambahkan!');
	}

	public function edit(Request $request, Privilege $privilege)
	{
		$data['privilege'] = $privilege;

		$ref_menu = Menu::whereIn('level', [1,2])->orderBy('parent_id')->orderBy('urutan')->get()->pluck('menu','id');
		
		$data['forms'] = array(
			'id_menu' => ['Menu', Form::select("id_menu", $ref_menu, $privilege->id_menu, ["class" => "form-control select2", "placeholder" => "Pilih Menu", "disabled"=>""]) ],
			'create' => ['Create Access', Form::select("create", ["1" => "Grant", "0" => "Deny"], $privilege->create, ["class" => "form-control select2", "placeholder" => "Create Data"]) ],
			'read' => ['Read Access', Form::select("read", ["1" => "Grant", "0" => "Deny"], $privilege->read, ["class" => "form-control select2","placeholder" => "Read Data"]) ],
			'show' => ['Detail Access', Form::select("show", ["1" => "Grant", "0" => "Deny"], $privilege->show, ["class" => "form-control select2","placeholder" => "Detail Data"]) ],
			'update' => ['Update Access', Form::select("update", ["1" => "Grant", "0" => "Deny"], $privilege->update, ["class" => "form-control select2","placeholder" => "Update Data"]) ],
			'delete' => ['Delete Access', Form::select("delete", ["1" => "Grant", "0" => "Deny"], $privilege->delete, ["class" => "form-control select2", "placeholder" => "Delete Data"]) ],
			'show_menu' => ['Show Menu', Form::select("show_menu", ["1" => "Grant", "0" => "Deny"], $privilege->show_menu, ["class" => "form-control select2","placeholder" => "Is menu shown to the role"]) ],
		);
		$data['role'] = Role::find($request->get('id_role'));
		return view('Privilege::privilege_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'create' => 'required',
			'delete' => 'required',
			'read' => 'required',
			'show' => 'required',
			'show_menu' => 'required',
			'update' => 'required',
		]);
		
		$privilege = Privilege::find($id);
		$privilege->create = $request->input("create");
		$privilege->delete = $request->input("delete");
		$privilege->read = $request->input("read");
		$privilege->show = $request->input("show");
		$privilege->show_menu = $request->input("show_menu");
		$privilege->update = $request->input("update");
		$privilege->updated_by = Auth::id();
		$privilege->save();

		return redirect()->route('privilege.index', ['id_role' => $request->get('id_role')])->with('message_success', 'Privilege berhasil diubah!');
	}

	public function destroy($id)
	{
		$privilege = Privilege::find($id);
		$privilege->deleted_by = Auth::id();
		$privilege->save();
		$privilege->delete();

		return back()->with('message_success', 'Privilege berhasil dihapus!');
	}

}
