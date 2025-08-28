<?php
namespace App\Modules\Config\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Config\Models\Config;

use Form;

class ConfigController extends Controller
{
	protected $title = "Config";
	public function index(Request $request)
	{
		$query = Config::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();
		return view('Config::config', array_merge($data, ['title' => $this->title]));
	}

	public function create()
	{
		
		$data['forms'] = array(
			'key' => ['Key', Form::text("key", old("key"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'deskripsi' => ['Deskripsi', Form::textarea("deskripsi", old("deskripsi"), ["class" => "form-control", "required" => "required"]) ],
			'default' => ['Default', Form::text("default", old("default"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'form_type' => ['Form Type', Form::text("form_type", old("form_type"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'form_label' => ['Form Label', Form::text("form_label", old("form_label"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'value' => ['Value', Form::textarea("value", old("value"), ["class" => "form-control", "required" => "required"]) ],
			
		);
		return view('Config::config_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'key' => 'required',
			'deskripsi' => 'required',
			'default' => 'required',
			'form_type' => 'required',
			'form_label' => 'required',
			'value' => 'required',
			
		]);

		$config = new Config();
		$config->key = $request->input("key");
		$config->deskripsi = $request->input("deskripsi");
		$config->default = $request->input("default");
		$config->form_type = $request->input("form_type");
		$config->form_label = $request->input("form_label");
		$config->value = $request->input("value");
		
		$config->created_by = Auth::id();
		$config->save();

		return redirect()->route('config.index')->with('message_success', 'Config berhasil ditambahkan!');
	}

	public function show(Config $config)
	{
		$data['config'] = $config;

		return view('Config::config_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Config $config)
	{
		$data['config'] = $config;

		
		$data['forms'] = array(
			'key' => ['Key', Form::text("key", $config->key, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "key"]) ],
			'deskripsi' => ['Deskripsi', Form::textarea("deskripsi", $config->deskripsi, ["class" => "form-control", "required" => "required", "id" => "deskripsi"]) ],
			'default' => ['Default', Form::text("default", $config->default, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "default"]) ],
			'form_type' => ['Form Type', Form::text("form_type", $config->form_type, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "form_type"]) ],
			'form_label' => ['Form Label', Form::text("form_label", $config->form_label, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "form_label"]) ],
			'value' => ['Value', Form::textarea("value", $config->value, ["class" => "form-control", "required" => "required", "id" => "value"]) ],
			
		);

		return view('Config::config_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'key' => 'required',
			'deskripsi' => 'required',
			'default' => 'required',
			'form_type' => 'required',
			'form_label' => 'required',
			'value' => 'required',
			
		]);
		
		$config = Config::find($id);
		$config->key = $request->input("key");
		$config->deskripsi = $request->input("deskripsi");
		$config->default = $request->input("default");
		$config->form_type = $request->input("form_type");
		$config->form_label = $request->input("form_label");
		$config->value = $request->input("value");
		
		$config->updated_by = Auth::id();
		$config->save();

		return redirect()->route('config.index')->with('message_success', 'Config berhasil diubah!');
	}

	public function destroy($id)
	{
		$config = Config::find($id);
		$config->deleted_by = Auth::id();
		$config->save();
		$config->delete();

		return back()->with('message_success', 'Config berhasil dihapus!');
	}

}
