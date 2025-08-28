<?php

return [
	'module_exception' => [
		'login',
		'register',
		'password',
		'verification',
		'logout', // auth
		'dashboard',
		'frontend',
		// 'snbp',
		'aktivasi',
		'registrasi',
		'kirimemail'
	],

	'translate_action' => [
		'index'   => 'read',
		'show'    => 'show',
		'create'  => 'create',
		'store'   => 'create',
		'edit'    => 'update',
		'update'  => 'update',
		'destroy' => 'delete',
		'delete'  => 'delete'
	],

	'login_using' => env('LOGIN_USING', 'email'),
];
