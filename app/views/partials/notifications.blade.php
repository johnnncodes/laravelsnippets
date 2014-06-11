@if (Session::has('message'))
	<div class="alert alert-{{ Session::get('messageType', 'danger') }}">{{ Session::get('message') }}</div>
@endif