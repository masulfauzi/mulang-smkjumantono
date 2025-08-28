@props(['errors'])

@if ($errors->any())
<div class="alert alert-light-danger color-danger fade show" role="alert">
    {{ implode('<br>', $errors->all()) }}
</div>
@endif

