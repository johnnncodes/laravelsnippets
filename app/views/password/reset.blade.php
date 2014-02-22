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
    <h1 class="text-center login-title">Fill in the fields below to set your new password</h1>
    <div class="account-wall">

      {{ Form::open(array('class'=>'form-signin')) }}

      {{ Form::hidden('token', $token) }}

      {{ Form::text('email', $value = null, array('placeholder' => 'Email', 'class'=> 'form-control', 'required' => 'required', 'autofocus' => 'autofocus')) }}

      {{ Form::password('password', array('placeholder' => 'Password', 'class'=> 'form-control', 'required' => 'required')) }}

      {{ Form::password('password_confirmation', array('placeholder' => 'Password Confirmation', 'class'=> 'form-control', 'required' => 'required')) }}

      {{ Form::submit('Reset password', array('class' => 'btn btn-lg btn-primary btn-block')) }}

      <span class="clearfix"></span>

      {{ Form::close() }}

    </div>
  </div>
</div>
@stop