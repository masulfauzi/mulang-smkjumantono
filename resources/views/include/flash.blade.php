@if ($errors->any())
    <div class="alert alert-light-danger color-danger alert-dismissible fade show" role="alert">
		<h5 class="alert-heading">Ups, ada kesalahan!</h5>
        <ul class="pb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session()->has('message_success'))
	<div class="alert alert-light-success color-success  alert-dismissible fade show" role="alert">
		{{ session('message_success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif
@if(session()->has('message_danger'))
	<div class="alert alert-light-danger color-danger  alert-dismissible fade show" role="alert">
		{{ session('message_danger') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif