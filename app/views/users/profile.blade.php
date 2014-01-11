@extends('layouts.master')

@section('content')

  <div class="row user-profile-wrapper">
    <div class="col-md-12">

      <div class="profile-pic-con">

        <div class="row">
          <div class="col-md-3">
            <img src="{{ $user->abs_photo_url }}" id="profile-pic" height="200" width="200">
          </div>

          <div class="col-md-9 actions">

          </div>
        </div>

      </div>

      <h3>{{ e($user->full_name) }}</h3>

      <h4>About Me:</h4>

      @if($user->about_me)
        <p>{{ e($user->about_me) }}</p>
      @else
        <p>No data available.</p>
      @endif

      <h4>Links:</h4>

      <div class="links">

        @if($user->website_url || $user->twitter_url || $user->facebook_url || $user->github_url)

          @if(e($user->website_url))
            <a href="{{ e($user->website_url) }}" target="_blank">{{ e($user->website_url) }}</a>
          @endif

          @if(e($user->twitter_url))
            <a href="{{ e($user->twitter_url) }}" target="_blank">Twitter.com</a>
          @endif

          @if(e($user->facebook_url))
            <a href="{{ e($user->facebook_url) }}" target="_blank">Facebook.com</a>
          @endif

          @if(e($user->github_url))
            <a href="{{ e($user->github_url) }}" target="_blank">Github.com</a>
          @endif

        @else
          <p>No data available.</p>
        @endif

      </div>

      <br>
      <a href="{{ route('user.getSnippets', $user->slug) }}" class="btn btn-primary">View submitted snippets</a>

    </div>
  </div>

@stop
