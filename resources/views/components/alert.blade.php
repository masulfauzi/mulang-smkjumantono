@props(['color', 'message'])
@if(session()->has('message_'.$color))
	<div class="alert alert-{{ $color }}" role="alert">
		{{ $message }}
	</div>
@endif