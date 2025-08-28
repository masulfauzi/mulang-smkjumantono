<?php
namespace App\Modules\Log\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Log\Models\Log;
use App\Modules\Users\Models\Users;

use Form;

class LogController extends Controller
{
	protected $title = "Log";
	public function index(Request $request)
	{
		$query = Log::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();
		return view('Log::log', array_merge($data, ['title' => $this->title]));
	}

	public function create()
	{
		$ref_users = Users::all()->pluck('name','id');
		
		$data['forms'] = array(
			'id_user' => ['User', Form::select("id_user", $ref_users, null, ["class" => "form-control select2"]) ],
			'aktivitas' => ['Aktivitas', Form::text("aktivitas", old("aktivitas"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'route' => ['Route', Form::text("route", old("route"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'action' => ['Action', Form::text("action", old("action"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'context' => ['Context', Form::text("context", old("context"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'data' => ['Data', Form::text("data", old("data"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);
		return view('Log::log_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_user' => 'required',
			'aktivitas' => 'required',
			'route' => 'required',
			'action' => 'required',
			'context' => 'required',
			'data' => 'required',
			
		]);

		$log = new Log();
		$log->id_user = $request->input("id_user");
		$log->aktivitas = $request->input("aktivitas");
		$log->route = $request->input("route");
		$log->action = $request->input("action");
		$log->context = $request->input("context");
		$log->data = $request->input("data");
		
		$log->created_by = Auth::id();
		$log->save();

		return redirect()->route('log.index')->with('message_success', 'Log berhasil ditambahkan!');
	}

	public function show(Log $log)
	{
		$data['log'] = $log;

		return view('Log::log_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Log $log)
	{
		$data['log'] = $log;

		$ref_users = Users::all()->pluck('name','id');
		
		$data['forms'] = array(
			'id_user' => ['User', Form::select("id_user", $ref_users, null, ["class" => "form-control select2"]) ],
			'aktivitas' => ['Aktivitas', Form::text("aktivitas", $log->aktivitas, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "aktivitas"]) ],
			'route' => ['Route', Form::text("route", $log->route, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "route"]) ],
			'action' => ['Action', Form::text("action", $log->action, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "action"]) ],
			'context' => ['Context', Form::text("context", $log->context, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "context"]) ],
			'data' => ['Data', Form::text("data", $log->data, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "data"]) ],
			
		);

		return view('Log::log_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_user' => 'required',
			'aktivitas' => 'required',
			'route' => 'required',
			'action' => 'required',
			'context' => 'required',
			'data' => 'required',
			
		]);
		
		$log = Log::find($id);
		$log->id_user = $request->input("id_user");
		$log->aktivitas = $request->input("aktivitas");
		$log->route = $request->input("route");
		$log->action = $request->input("action");
		$log->context = $request->input("context");
		$log->data = $request->input("data");
		
		$log->updated_by = Auth::id();
		$log->save();

		return redirect()->route('log.index')->with('message_success', 'Log berhasil diubah!');
	}

	public function destroy($id)
	{
		$log = Log::find($id);
		$log->deleted_by = Auth::id();
		$log->save();
		$log->delete();

		return back()->with('message_success', 'Log berhasil dihapus!');
	}

}
