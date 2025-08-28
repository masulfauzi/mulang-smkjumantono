<?php
namespace App\Modules\UserRole\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\UserRole\Models\UserRole;

use Form;

class UserRoleController extends Controller
{
	protected $title = "User Role";
	public function index(Request $request)
	{
		$query = UserRole::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();
		return view('UserRole::userrole', array_merge($data, ['title' => $this->title]));
	}

	public function create()
	{
		
		$data['forms'] = array(
			'id_user' => ['User', Form::text("id_user", old("id_user"), ["class" => "form-control","placeholder" => ""]) ],
			'id_role' => ['Role', Form::text("id_role", old("id_role"), ["class" => "form-control","placeholder" => ""]) ],
			
		);
		return view('UserRole::userrole_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_user' => 'required',
			'id_role' => 'required',
			
		]);

		$userrole = new UserRole();
		$userrole->id_user = $request->input("id_user");
		$userrole->id_role = $request->input("id_role");
		
		$userrole->created_by = Auth::id();
		$userrole->save();

		return redirect()->route('userrole.index')->with('message_success', 'User Role berhasil ditambahkan!');
	}

	public function edit(UserRole $userrole)
	{
		$data['userrole'] = $userrole;

		
		$data['forms'] = array(
			'id_user' => ['User', Form::text("id_user", $userrole->id_user, ["class" => "form-control","placeholder" => "", "id" => "id_user"]) ],
			'id_role' => ['Role', Form::text("id_role", $userrole->id_role, ["class" => "form-control","placeholder" => "", "id" => "id_role"]) ],
			
		);

		return view('UserRole::userrole_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_user' => 'required',
			'id_role' => 'required',
			
		]);
		
		$userrole = UserRole::find($id);
		$userrole->id_user = $request->input("id_user");
		$userrole->id_role = $request->input("id_role");
		
		$userrole->updated_by = Auth::id();
		$userrole->save();

		return redirect()->route('userrole.index')->with('message_success', 'User Role berhasil diubah!');
	}

	public function destroy($id)
	{
		$userrole = UserRole::find($id);
		$userrole->deleted_by = Auth::id();
		$userrole->save();
		$userrole->delete();

		return back()->with('message_success', 'User Role berhasil dihapus!');
	}

}
