@extends('layouts.master')

@section('content')

  <div class="starred-snippets">

    <h4 class="heading">Starred Snippets</h4>

    @if (count($starred_snippets) > 0)
      <ul class="snippets-list">
        @foreach ($starred_snippets as $snippet)
          <li class="snippet">
            <span class="date">{{ $snippet->snippet->humanCreatedAt }}</span>
            -
            <a href="{{ route('member.snippet.getShow', $snippet->snippet->slug) }}">{{ e($snippet->snippet->title) }}</a>
            |
            <span class="hits">Views: @if ($snippet->snippet->hasHits()) {{ $snippet->snippet->hits }} @else 0 @endif</span>
            |
            <span class="hits">Comments: @if ($snippet->snippet->comments) {{ $snippet->snippet->comments }} @else 0 @endif</span>
            |
            <span class="hits">Starred: {{ $snippet->snippet->starred->count() }}</span>
          </li>
        @endforeach
      </ul>

    @else
      <p>No starred snippets yet. <a href="{{ route('snippet.getIndex') }}">Why not add one?</a></p>
    @endif
  </div>

  <div class="my-snippets">

    <h4 class="heading">My Snippets</h4>

    @if (count($my_snippets) > 0)
      <ul class="snippets-list">
        @foreach ($my_snippets as $snippet)
          <li class="snippet">
            <span class="date">{{ $snippet->humanCreatedAt }}</span>
            -
            <a href="{{ route('member.snippet.getShow', $snippet->slug) }}">{{ e($snippet->title) }}</a>
            |
            <span class="hits">Views: @if ($snippet->hasHits()) {{ $snippet->hits }} @else 0 @endif</span>
            |
            <span class="hits">Comments: @if ($snippet->comments) {{ $snippet->comments }} @else 0 @endif</span>
            |
            <span class="hits">Starred: {{ $snippet->starred->count() }}</span>
            |
            <span class="approved">@if($snippet->approved) Approved @else Pending @endif</span>
            |
            <span>Actions: </span>
            <span class="controls">
              <a href="{{ route('member.snippet.getEdit', $snippet->slug) }}" class="btn btn-primary">Edit</a>

              {{--
                {{ Form::model($snippet, array('route' => array('user.deleteSnippet', $snippet->author->slug, $snippet->id), 'method' => 'delete', 'class'=>'delete-snippet-form')) }}
                  {{ Form::submit('delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
              --}}

            </span>
          </li>
        @endforeach
      </ul>

      {{ $my_snippets->links() }}

    @else
      <p>No snippets yet. <a href="{{ route('member.snippet.getCreate') }}">Why not add one?</a></p>
    @endif
  </div>

@stop
