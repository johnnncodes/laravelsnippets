@extends('layouts.master')
@section('content')
    {{ Form::model($user,['route' => ['user.putSettings',$user->slug], 'method' =>'PUT', 'class'=>'form', 'role'=>'form']) }}
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class='form-group @if($errors->has('username')) has-error @endif'>
                        <!-- `Username` Field -->
                        {{ Form::label('username', 'Username') }}
                        {{ Form::text('username', @$user->username, ['class'=>'form-control', 'readonly' => true]) }}
                        @if($errors->has('username'))<span
                                class="help-block">{{$errors->first('username')}}</span>@endif
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                        <!-- `Email` Field -->
                        {{ Form::label('email', 'Email') }}
                        {{ Form::email('email', @$user->email, ['class'=>'form-control', 'readonly' => true]) }}
                        @if($errors->has('email'))<span class="help-block">{{$errors->first('email')}}</span>@endif
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class='form-group @if($errors->has('first_name')) has-error @endif'>
                        <!-- `First name` Field -->
                        {{ Form::label('first_name', 'First name') }}
                        {{ Form::text('first_name', @$user->first_name, ['class'=>'form-control', 'placeholder' => 'Your first name']) }}
                        @if($errors->has('first_name'))<span
                                class="help-block">{{$errors->first('first_name')}}</span>@endif
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class='form-group @if($errors->has('last_name')) has-error @endif'>
                        <!-- `Last name` Field -->
                        {{ Form::label('last_name', 'Last name') }}
                        {{ Form::text('last_name', @$user->last_name, ['class'=>'form-control', 'placeholder' => 'Your last name']) }}
                        @if($errors->has('last_name'))<span
                                class="help-block">{{$errors->first('last_name')}}</span>@endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class='form-group @if($errors->has('twitter_url')) has-error @endif'>
                        <!-- `Twitter url` Field -->
                        {{ Form::label('twitter_url', 'Twitter url') }}
                        {{ Form::text('twitter_url', @$user->twitter_url, ['class'=>'form-control', 'placeholder' => 'Twitter URL']) }}
                        @if($errors->has('twitter_url'))<span
                                class="help-block">{{$errors->first('twitter_url')}}</span>@endif
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class='form-group @if($errors->has('facebook_url')) has-error @endif'>
                        <!-- `Facebook url` Field -->
                        {{ Form::label('facebook_url', 'Facebook url') }}
                        {{ Form::text('facebook_url', @$user->facebook_url, ['class'=>'form-control', 'placeholder' => 'Facebook URL']) }}
                        @if($errors->has('facebook_url'))<span
                                class="help-block">{{$errors->first('facebook_url')}}</span>@endif
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class='form-group @if($errors->has('github_url')) has-error @endif'>
                        <!-- `Github url` Field -->
                        {{ Form::label('github_url', 'Github url') }}
                        {{ Form::text('github_url', @$user->github_url, ['class'=>'form-control', 'placeholder' => 'Github URL']) }}
                        @if($errors->has('github_url'))<span
                                class="help-block">{{$errors->first('github_url')}}</span>@endif
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div class='form-group @if($errors->has('website_url')) has-error @endif'>
                        <!-- `Website url` Field -->
                        {{ Form::label('website_url', 'Website url') }}
                        {{ Form::text('website_url', @$user->website_url, ['class'=>'form-control', 'placeholder' => 'Website URL']) }}
                        @if($errors->has('website_url'))<span
                                class="help-block">{{$errors->first('website_url')}}</span>@endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class='form-group'>
                        <!-- `About me` Field -->
                        {{ Form::label('about_me', 'About me') }}
                        {{ Form::textarea('about_me', @$user->about_me, ['class'=>'form-control', 'placeholder' => 'Write something interesting about yourself...']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-12'>
            <!-- Form actions -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <h2>Reset your password</h2>

            <div class="form-group @if($errors->has('website_url')) has-error @endif">
                {{Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'New password'])}}
                @if($errors->has('password'))<span
                        class="help-block">{{$errors->first('password')}}</span>@endif
            </div>
            <div class="form-group @if($errors->has('website_url')) has-error @endif">
                {{Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => 'Confirm new password'])}}
                @if($errors->has('password_confirmation'))<span
                        class="help-block">{{$errors->first('password_confirmation')}}</span>@endif
            </div>
            <button type='submit' class='btn btn-primary btn-block'>Update profile</button>
        </div>
    </div>
    {{ Form::close() }}

@stop