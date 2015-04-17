@extends('layouts.master')

@section('content')

    <div class="band">
        <div class="user-profiles-wrapper">

            <h1 class="heading">Members</h1>

            @if ($users->count())

                @foreach($users->chunk(4) as $usersChunked)
                    <div class="row">
                        @foreach($usersChunked as $user)
                            <div class="col-lg-3 text-center">
                                <div class="col-md-12">
                                    <img src="{{ $user->abs_photo_url }}" class="widget-author-avatar" height="65"
                                         width="65">
                                </div>

                                <div class="col-md-12">
                                    <a href="{{ route('user.getProfile', $user->slug) }}">
                                        <h4 class="name">{{ $user->full_name }}</h4>
                                    </a>

                                    <a href="{{ route('user.getSnippets', $user->slug) }}">
                                        <p>Submitted snippets: {{ $user->snippets_count }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                {{ $users->links() }}

            @else

                <h3>No site members yet.</h3>

            @endif


        </div>
    </div>

@stop
