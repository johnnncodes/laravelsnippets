@extends('layouts.master')

@section('content')
  <div class="row home-page-wrapper">

      <div class="col-md-12">

        <h3>Welcome to laravelsnippets.com</h3>
        <p>
          A repository of useful code snippets for Laravel PHP framework. <a href="{{ route('member.snippet.getCreate') }}">Submit</a>, grab and share!
        </p>
        <p>
          Source code of the site - <a href="https://github.com/basco-johnkevin/laravelsnippets" target="_blank">Github link</a> . We accept pull requests! =)
        </p>

        <div class="recent-snippets">
          <h4 class="heading">Recent Snippets</h4>

          @if (count($snippets) > 0)
            <ul class="snippets-list">
              @foreach ($snippets as $snippet)
                <li class="snippet">
                  <span class="date">{{ $snippet->humanCreatedAt }}</span>
                  -
                  <a href="{{ route('snippet.getShow', $snippet->slug) }}">{{ e($snippet->title) }}</a>
                  <span class="author">by (<a href="{{ route('user.getProfile', $snippet->author->slug) }}">{{ e($snippet->author->full_name) }}</a>)</span>
                  |
                  <span class="hits">Views: @if($snippet->hasHits()) {{ $snippet->hits }} @else 0 @endif</span>
                  |
                  <span class="hits">Comments: @if($snippet->comments) {{ $snippet->comments }} @else 0 @endif</span>
                </li>
              @endforeach
            </ul>

            {{ $snippets->links() }}

          @else
            <p>No snippets available.</p>
          @endif
        </div>

        @if (count($mostViewedSnippets) > 0)
          <div class="most-viewed-snippets">
            <h4 class="heading">Top 5 Most Viewed Snippets</h4>

            <ul class="snippets-list">
              @foreach ($mostViewedSnippets as $snippet)
                <li class="snippet">
                  <span class="date">{{ $snippet->humanCreatedAt }}</span>
                  -
                  <a href="{{ route('snippet.getShow', $snippet->slug) }}">{{ e($snippet->title) }}</a>
                  <span class="author">by (<a href="{{ route('user.getProfile', $snippet->author->slug) }}">{{ e($snippet->author->full_name) }}</a>)</span>
                  |
                  <span class="hits">Views: @if($snippet->hasHits()) {{ $snippet->hits }} @else 0 @endif</span>
                  |
                  <span class="hits">Comments: @if($snippet->comments) {{ $snippet->comments }} @else 0 @endif</span>
                </li>
              @endforeach
            </ul>

          </div>
        @endif

        @if (count($topSnippetContributors) > 0)
          <div class="top-snippet-contributors">
            <h4 class="heading">Top 5 Snippet Contributors</h4>

            <ul class="contributors-list">
              @foreach ($topSnippetContributors as $contributor)
                <li class="contributor">
                  <a href="{{ route('user.getProfile', $contributor->slug) }}">
                   {{ $contributor->full_name }}
                  </a>
                  -
                  <a href="{{ route('user.getSnippets', $contributor->slug) }}">
                    <span>{{ $contributor->snippets_count }} submitted snippets</span>
                  </a>
                </li>
              @endforeach
            </ul>

          </div>
        @endif

      </div>


  </div>
@stop

