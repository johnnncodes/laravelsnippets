@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-md-12">

      <div class="recent-snippets">

        <h4 class="heading">Snippets by "{{ e($user->full_name) }}"</h4>

        @if (count($snippets) > 0)
          <ul class="snippets-list">
            @foreach ($snippets as $snippet)
              <li class="snippet">
                <span class="date">{{ $snippet->created_at }}</span>
                -
                <a href="{{ route('snippet.getShow', $snippet->slug) }}">{{ e($snippet->title) }}</a>
                <span class="author">by (<a href="{{ route('user.getProfile', $snippet->author->slug) }}">{{ e($snippet->author->full_name) }}</a>)</span>
                |
                <span class="hits">Views: @if($snippet->hasHits()) {{ $snippet->hits }} @else 0 @endif</span>
              </li>
            @endforeach
          </ul>

          {{ $snippets->links() }}

        @else
          <p>No snippets available.</p>
        @endif
      </div>

    </div>
  </div>
@stop

