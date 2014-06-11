@extends('layouts.master')

@section('content')

	<div class="row">

		@if ($errors->has())
			<p>We encountered the following errors:</p>
			<ul>
				@foreach($errors->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
		@endif

		<div class="col-sm-6 col-sm-offset-3">

			<h1 class="text-center">Reset Your Password</h1>

			{{ Form::open() }}

				{{ Form::field(['name' => 'email', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Email Address', 'parameters' => ['required', 'autofocus']]) }}

				<p>{{ HTML::submit('RESET PASSWORD', array('class' => 'btn-lg btn-primary btn-block')) }}</p>

			{{ Form::close() }}

		</div>

	</div>

@stop