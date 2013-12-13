@extends('layouts.master')

@section('content')

    <div class="row registration-page-wrapper">

      @if($errors->has())
        <p>We encountered the following errors:</p>
        <ul>
          @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
          @endforeach
        </ul>
      @endif

      <div class="col-sm-6 col-md-6 col-md-offset-3">
        <h1 class="text-center login-title">Fill in the fields to register</h1>
        <div class="account-wall">
          {{ Form::open(array('route' => 'auth.postSignup', 'class'=>'form-signin form-register')) }}
            {{ Form::text('username', $value = null, array('placeholder' => 'Username', 'class'=> 'form-control', 'required' => 'required', 'autofocus' => 'autofocus' )) }}
            {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control middle', 'required' => 'required')) }}
            {{ Form::password('password_confirmation', array('placeholder' => 'Password confirmation', 'class' => 'form-control middle', 'required' => 'required')) }}
            {{ Form::text('first_name', $value = null, array('placeholder' => 'First name', 'class'=> 'form-control middle', 'required' => 'required' )) }}
            {{ Form::text('last_name', $value = null, array('placeholder' => 'Last name', 'class'=> 'form-control middle', 'required' => 'required' )) }}
            {{ Form::text('email', $value = null, array('placeholder' => 'Email', 'class'=> 'form-control bottom', 'required' => 'required' )) }}
            {{ Form::submit('Register', array('class' => 'btn btn-lg btn-primary btn-block')) }}
            <span class="clearfix"></span>
          {{ Form::close() }}
        </div>
        <a href="{{ route('auth.getLogin') }}" class="text-center new-account">Already have an account? Sign In</a>
      </div>
    </div>

@stop