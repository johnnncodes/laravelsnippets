@extends('layouts.master')

@section('content')

	<div class="band">

		@if( $errors->has() )
			<p>We encountered the following errors:</p>
			<ul>
				@foreach($errors->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
		@endif

		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">

				<h1 class="text-center">Sign in to your account</h1>

				{{ Form::open(array('route' => 'auth.postLogin', 'class'=>'form-signin')) }}

					{{ Form::field(['name' => 'username', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Username', 'parameters' => ['required', 'autofocus']]) }}
					{{ Form::field(['name' => 'password', 'error' => $errors, 'no_label' => true, 'placeholder' => 'Password', 'type' => 'password', 'parameters' => ['required']]) }}
					<p>{{ HTML::submit('Sign in', array('class' => 'btn btn-lg btn-primary btn-block')) }}</p>

					<!-- next url to redirect to after logging in -->
					@if ( isset( $next ) )
						{{ Form::hidden('next', $value = 'snippets/create') }}
					@endif

					<!-- <label class="checkbox pull-left"><input type="checkbox" value="remember-me"> Remember me</label> -->
				{{ Form::close() }}

				<ul class="list-inline">
					<li><a href="{{ route('auth.getSignup') }}" class="text-center new-account">Create an account</a></li>
					<li><a href="{{ route('password.remind') }}" class="text-center new-account">Forgot your password?</a></li>
				</ul>

			</div>
		</div>

	</div>

@stop
