@extends('layouts.master')

@section('content')

    <div class="row login-page-wrapper">

      @if($errors->has())
        <p>We encountered the following errors:</p>
        <ul>
          @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
          @endforeach
        </ul>
      @endif

      <div class="col-sm-6 col-md-6 col-md-offset-3">
        <h1 class="text-center login-title">Fill in the fields to sign in</h1>
        <div class="account-wall">
          <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
          {{ Form::open(array('route' => 'auth.postLogin', 'class'=>'form-signin')) }}
            {{ Form::text('username', $value = null, array('placeholder' => 'Username', 'class'=> 'form-control', 'required' => 'required', 'autofocus' => 'autofocus' )) }}
            {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control', 'required' => 'required')) }}
            {{ Form::submit('Sign in', array('class' => 'btn btn-lg btn-primary btn-block')) }}

            <!-- next url to redirect to after logging in -->
            @if(isset($next))
              {{ Form::hidden('next', $value = 'snippets/create') }}
            @endif

<!--             <label class="checkbox pull-left">
              <input type="checkbox" value="remember-me">
              Remember me
            </label> -->
            <span class="clearfix"></span>
          {{ Form::close() }}
        </div>
        <a href="{{ route('auth.getSignup') }}" class="text-center new-account">Create an account </a>
      </div>
    </div>

@stop