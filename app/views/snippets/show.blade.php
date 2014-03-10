@extends('layouts.master')

@if($snippet->description)
  @section('meta_description')
    <meta name="description" content="{{ e($snippet->description) }}">
  @stop
@endif

@if($snippet->author)
  @section('meta_author')
    <meta name="author" content="{{ e($snippet->author->fullName) }}">
  @stop
@endif

@section('title')
  <title>{{ e($snippet->title) }} | LaravelSnippets.com</title>
@stop

@section('content')

  <div class="row snippet-detail-wrapper">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-6">
          <h3>{{ e($snippet->title) }}</h3>
        </div>
        <div class="col-md-6">
          <div class="btn-group snippet-starred {{ $has_starred ? 'snippet-starred-active' : '' }}">
            @if ($has_starred)
              <a href="{{ URL::route( 'snippet.unStar', array( $snippet->slug ) ) }}" class="btn btn-default"><i class="fa fa-star"></i> Unstar</a>
            @else
              <a href="{{ URL::route( 'snippet.star', array( $snippet->slug ) ) }}" class="btn btn-default"><i class="fa fa-star"></i> Star</a>
            @endif
            <div class="btn btn-default snippet-starred-count">{{ $snippet->starred->count() }}</div>
          </div>
        </div>
      </div>

      @if($snippet->description)
        <p>Description: {{ Purifier::clean(Parsedown::instance()->parse($snippet->description), array('HTML.Nofollow' => true)) }}</p>
      @endif

      @if($snippet->credits_to)
        @if($snippet->creditsToLink)
          <p>
            Credits to: <a href="{{ $snippet->creditsToLink }}">{{ e($snippet->credits_to) }}</a>
          </p>
        @else
          <p>Credits to: {{ e($snippet->credits_to) }}</p>
        @endif
      @endif

      @if($snippet->resource)
        <p>Resource: <a href="{{ e($snippet->resource) }}" target="_blank">{{ e($snippet->resource) }}</a></p>
      @endif

      <pre>
        <code class="prettyprint linenums js-prettyprint">{{ e($snippet->body) }}</code>
      </pre>

      <div class="meta">
        <span class='st_facebook_hcount' displayText='Facebook'></span>
        <span class='st_twitter_hcount' displayText='Tweet' st_via='LaravelSnippets #Laravel #snippet'></span>
        <span class='st_linkedin_hcount' displayText='LinkedIn'></span>
        <span class='st_googleplus_hcount' displayText='Google +'></span>
        <span class='st_tumblr_hcount' displayText='Tumblr'></span>

          @if (count($snippet->tags) > 0)
            <div class="tags">
              <p class="pull-left">Tags:</p>
              <ul class="tags-list">
                @foreach ($snippet->tags as $tag)
                  <li class="tag">
                    <a href="{{ route('tag.getShow', $tag->slug) }}">
                      <span class="label label-primary">{{ e($tag->name) }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
              <span class="clearfix"></span>
            </div>
          @endif

        <p>
          Submitted {{ $snippet->humanCreatedAt }} by
          <a href="{{ route('user.getProfile', $snippet->author->slug) }}">{{ e($snippet->author->full_name) }}</a>

          (<a href="{{ route('user.getSnippets', $snippet->author->slug) }}">{{ $snippet->author->snippets_count }} {{ Str::plural('snippet', $snippet->author->snippets_count) }}</a>).
        </p>
        <p>Updated {{ $snippet->humanUpdatedAt }}.</p>
        <p>
          Views:
          @if ($snippet->hasHits()) {{ $snippet->hits }}
          @else
            0
          @endif
        </p>
      </div>

      @if(App::environment() === 'production')

        <div class="disqus">
          <div id="disqus_thread"></div>
          <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
          <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        </div>

      @endif

    </div>

  </div>

@stop

@section('scripts')

  @if(App::environment() === 'production')

    <script type="text/javascript">
      /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
      var disqus_shortname = 'laravel-snippets'; // required: replace example with your forum shortname
      var disqus_identifier = 'snippet-' + '{{ $snippet->slug }}';
      var disqus_title = '{{ $snippet->title }}';

      /* * * DON'T EDIT BELOW THIS LINE * * */
      (function () {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
      })();
    </script>

  @endif

@stop
