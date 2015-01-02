@extends('layouts.master')

@section('content')

	<div class="band">

		@if ($errors->has())
			<p>We encountered the following errors:</p>
			<ul>
				@foreach($errors->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
		@endif

		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">

				<h1 class="text-center">Fill in the fields to register</h1>

				{{ Form::open(array('route' => 'auth.postSignup', 'class'=>'form-signin form-register')) }}

					{{ Form::field(['name' => 'username', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Username', 'parameters' => ['required', 'autofocus']]) }}
					{{ Form::field(['name' => 'password', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Password', 'parameters' => ['required'], 'type' => 'password']) }}
					{{ Form::field(['name' => 'password_confirmation', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Password confirmation', 'parameters' => ['required'], 'type' => 'password']) }}
					{{ Form::field(['name' => 'first_name', 'error' => $errors, 'no_label' => true, 'placeholder' => 'First name', 'parameters' => ['required']]) }}
					{{ Form::field(['name' => 'last_name', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Last name', 'parameters' => ['required']]) }}
					{{ Form::field(['name' => 'email', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Email Address', 'parameters' => ['required']]) }}
					<p>{{ HTML::submit('Register', array('class' => 'btn btn-lg btn-primary btn-block')) }}</p>

				{{ Form::close() }}

				<p><a href="{{ route('auth.getLogin') }}" class="text-center new-account">Already have an account? Sign In</a></p>

			</div>
		</div>

	</div>

@stop