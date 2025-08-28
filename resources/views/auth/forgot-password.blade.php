@extends('auth.master-auth')
@section('main')
	<div class="row h-100">
		<div class="col-lg-5 col-12">
			<div id="auth-left">
				<div class="auth-logo">
					<a href="/"><img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo"></a>
				</div>
				<h1 class="auth-title">Forgot Password?</h1>
				{{-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> --}}

				<!-- Session Status -->
				<x-auth-session-status class="mb-4" :status="session('status')" />

				<!-- Validation Errors -->
				<x-auth-validation-errors class="mb-4" :errors="$errors" />

				<form method="POST" action="">
					@csrf
					<x-form-group class="position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" :value="old('email')" required autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </x-form-group>
					<button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim</button>
				</form>
				<div class="text-center mt-5 text-lg fs-4">
					<p class="text-gray-600">Don't have an account? <a href="{{ route('aktivasi') }}"
							class="font-bold">Sign
							up</a>.</p>
					@if (Route::has('password.request'))
						<p><a class="font-bold" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>.</p>
					@endif
				</div>
			</div>
		</div>
		<div class="col-lg-7 d-none d-lg-block">
			<div id="auth-right">

			</div>
		</div>
	</div>
@endsection