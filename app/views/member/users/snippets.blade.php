@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-md-12">

      <div class="recent-snippets">

        <h4 class="heading">My Snippets</h4>

        @if (count($snippets) > 0)
          <ul class="snippets-list">
            @foreach ($snippets as $snippet)
              <li class="snippet">
                <span class="date">{{ $snippet->created_at }}</span>
                -
                <a href="{{ route('member.snippet.getShow', $snippet->slug) }}">{{ e($snippet->title) }}</a>
                |
                <span class="hits">Views: @if($snippet->hasHits()) {{ $snippet->hits }} @else 0 @endif</span>

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

          {{ $snippets->links() }}

        @else
          <p>No snippets available.</p>
        @endif
      </div>

    </div>
  </div>
@stop

