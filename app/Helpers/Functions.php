<?php
use App\Helpers\Permission;

if (! function_exists('can')) {
    function can($route) {
		$elm = explode('.', $route);
		$menu = reset($elm);
		$action = end($elm);

		$previleges = session('previleges');
		// return $previleges[$menu][$action];
		return true;
    }
}

if (! function_exists('get')) {
    function get($what) {
		switch ($what) {
			case 'active_role':
				$here = session('active_role')['role'];
				break;
			case 'active_role_id':
				$here = session('active_role')['id'];
				break;
			
			default:
				$here = '';
				break;
		}

		return $here;
    }
}

if (! function_exists('get_semester')) {
    function get_semester($what) {
		switch ($what) {
			case 'active_semester':
				$here = session('active_semester')['semester'];
				break;
			case 'active_semester_id':
				$here = session('active_semester')['id'];
				break;
			
			default:
				$here = '';
				break;
		}

		return $here;
    }
}

if (! function_exists('button')) {
    function button($route, $title, $id = null, $class = "btn-primary") {
		$elm = explode('.', $route);
		$action = end($elm);
		$allowed = can($route);
		if($action == 'create'){
			$button = $allowed ? '<a href="'.route($route, $id).'" class="btn btn-sm icon icon-left float-end '.$class.'"><i class="fa fa-plus"></i> Tambah '.$title.'</a>' 
					: '<button class="btn btn-sm icon icon-left float-end btn-secondary disabled"><i class="fa fa-plus"></i> Tambah '.$title.'</button>';
		}else if($action == 'edit'){
			$class = "btn-outline-primary";
			$button = $allowed ? '<a href="'.route($route, $id).'" class="btn btn-sm icon icon-left '.$class.'"><i class="fa fa-pencil-alt"></i> Edit </a>' 
					: '<button class="btn btn-sm icon icon-left btn-secondary disabled"><i class="fa fa-pencil-alt"></i> Edit </button>';
		}else if($action == 'destroy'){
			$class = "btn-outline-danger";
			$button = $allowed ? '<button onclick="deleteConfirm(\''.route($route, $id).'\')" class="btn btn-sm icon icon-left '.$class.'"><i class="fa fa-trash"></i> Delete</button>'
								: '<button class="btn btn-sm icon icon-left btn-secondary disabled"><i class="fa fa-trash"></i> Delete </button>';
		}else{
			$class = "btn-outline-dark";
			$button = $allowed ? '<a href="'.route($route, $id).'" class="btn btn-sm icon icon-left '.$class.'"><i class="fa fa-arrow-right"></i> '.$title.' </a>' 
					: '<button class="btn btn-sm icon icon-left btn-secondary disabled"><i class="fa fa-arrow-right"></i> '.$title.' </button>';
		}
		return $button;
    }
}