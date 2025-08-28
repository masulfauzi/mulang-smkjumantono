<?php
namespace App\Modules\Device\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Device\Models\Device;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Device";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Device::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Device::device', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'nama_device' => ['Nama Device', Form::text("nama_device", old("nama_device"), ["class" => "form-control","placeholder" => ""]) ],
			'app_key' => ['App Key', Form::text("app_key", old("app_key"), ["class" => "form-control","placeholder" => ""]) ],
			'auth_key' => ['Auth Key', Form::text("auth_key", old("auth_key"), ["class" => "form-control","placeholder" => ""]) ],
			'last_used' => ['Last Used', Form::text("last_used", old("last_used"), ["class" => "form-control datetimepicker"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Device::device_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_device' => 'required',
			'app_key' => 'required',
			'auth_key' => 'required',
			'last_used' => 'required',
			
		]);

		$device = new Device();
		$device->nama_device = $request->input("nama_device");
		$device->app_key = $request->input("app_key");
		$device->auth_key = $request->input("auth_key");
		$device->last_used = $request->input("last_used");
		
		$device->created_by = Auth::id();
		$device->save();

		$text = 'membuat '.$this->title; //' baru '.$device->what;
		$this->log($request, $text, ['device.id' => $device->id]);
		return redirect()->route('device.index')->with('message_success', 'Device berhasil ditambahkan!');
	}

	public function show(Request $request, Device $device)
	{
		$data['device'] = $device;

		$text = 'melihat detail '.$this->title;//.' '.$device->what;
		$this->log($request, $text, ['device.id' => $device->id]);
		return view('Device::device_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Device $device)
	{
		$data['device'] = $device;

		
		$data['forms'] = array(
			'nama_device' => ['Nama Device', Form::text("nama_device", $device->nama_device, ["class" => "form-control","placeholder" => "", "id" => "nama_device"]) ],
			'app_key' => ['App Key', Form::text("app_key", $device->app_key, ["class" => "form-control","placeholder" => "", "id" => "app_key"]) ],
			'auth_key' => ['Auth Key', Form::text("auth_key", $device->auth_key, ["class" => "form-control","placeholder" => "", "id" => "auth_key"]) ],
			'last_used' => ['Last Used', Form::text("last_used", $device->last_used, ["class" => "form-control datetimepicker", "id" => "last_used"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$device->what;
		$this->log($request, $text, ['device.id' => $device->id]);
		return view('Device::device_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_device' => 'required',
			'app_key' => 'required',
			'auth_key' => 'required',
			'last_used' => 'required',
			
		]);
		
		$device = Device::find($id);
		$device->nama_device = $request->input("nama_device");
		$device->app_key = $request->input("app_key");
		$device->auth_key = $request->input("auth_key");
		$device->last_used = $request->input("last_used");
		
		$device->updated_by = Auth::id();
		$device->save();


		$text = 'mengedit '.$this->title;//.' '.$device->what;
		$this->log($request, $text, ['device.id' => $device->id]);
		return redirect()->route('device.index')->with('message_success', 'Device berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$device = Device::find($id);
		$device->deleted_by = Auth::id();
		$device->save();
		$device->delete();

		$text = 'menghapus '.$this->title;//.' '.$device->what;
		$this->log($request, $text, ['device.id' => $device->id]);
		return back()->with('message_success', 'Device berhasil dihapus!');
	}

}
