@extends('layouts.master')

@section('content')
  <div class="row user-profiles-wrapper">
    <div class="col-md-12">

      <div>

        <h4 class="heading">Members:</h4>

        @if ($users)
          <ul class="list-unstyled">
            @if(count($users))
              @foreach ($users as $user)
                <li class="profile">

                  <div class="row">
                    <div class="col-md-2">
                      <img src="{{ $user->abs_photo_url }}" class="profile-pic" height="120" width="120">
                    </div>

                    <div class="col-md-10">
                      <a href="{{ route('user.getProfile', $user->slug) }}">
                        <h4 class="name">{{ $user->full_name }}</h4>
                      </a>

                      @if($user->about_me)
                        <p>{{ Str::limit($user->about_me, 180) }}</p>
                      @endif

                      <a href="{{ route('user.getSnippets', $user->slug) }}">
                        <p>Submitted snippets: {{ $user->snippets_count }}</p>
                      </a>
                    </div>
                  </div>

                </li>
              @endforeach
            @else
              <li>
                <p>No members yet.</p>
              </li>
            @endif
          </ul>

          {{ $users->links() }}

        @else
          <p>No site members yet.</p>
        @endif

      </div>

    </div>
  </div>
@stop
