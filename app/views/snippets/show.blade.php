@extends('layouts.master')

@if ($snippet->description)
	@section('meta_description')
		<meta name="description" content="{{ e($snippet->description) }}">
	@stop
@endif

@if ($snippet->author)
	@section('meta_author')
		<meta name="author" content="{{ e($snippet->author->fullName) }}">
	@stop
@endif

@section('title')
	<title>{{ e($snippet->title) }} | {{ Config::get('site.title') }}</title>
@stop

@section('content')

	<div class="row">

		<div class="col-md-9">

			<a href="http://tutsbucket.com/kemh" target="_blank">
			    <img src="{{ asset('assets/images/glee-help-desk-software.png') }}" alt="Glee Help Desk" class="img-responsive" style="max-height: 125px; display: block; margin: auto; padding-top: 20px; padding-bottom: 20px;">
			</a>

			<div class="row">
				<div class="col-md-8">
					<h1>{{ e($snippet->title) }}</h1>
				</div>
				<div class="col-md-4">
					<div class="snippet-stats">
						<div class="snippet-stats-views"><i class="fa fa-eye"></i> {{ $snippet->hasHits() ? $snippet->hits : '0' }} views</div>
						<div class="snippet-stats-stars btn-group snippet-starred {{ $has_starred ? 'snippet-stats-stars-active' : '' }}">
							@if ($has_starred)
								<a href="{{ URL::route( 'snippet.unStar', array( $snippet->slug ) ) }}" class="btn btn-default"><i class="fa fa-star"></i> Unstar</a>
							@else
								<a href="{{ URL::route( 'snippet.star', array( $snippet->slug ) ) }}" class="btn btn-default"><i class="fa fa-star"></i> Star</a>
							@endif
							<div class="btn btn-default snippet-stats-stars-count">{{ $snippet->starred->count() }}</div>
						</div>
					</div>
				</div>
			</div>

			<hr>

			@if($snippet->description)
				<div class="snippet-description">
					<h2 class="h5"><strong>Description:</strong></h2>
					<p>{{ Purifier::clean( Parsedown::instance()->parse( $snippet->description ), array('HTML.Nofollow' => true) ) }}</p>
				</div>
			@endif

			@if($snippet->credits_to)
				@if ( $snippet->creditsToLink )
					<p>Credits to: <a href="{{ $snippet->creditsToLink }}">{{ e($snippet->credits_to) }}</a></p>
				@else
					<p>Credits to: {{ e($snippet->credits_to) }}</p>
				@endif
			@endif

			@if($snippet->resource)
				<p>Resource: <a href="{{ e($snippet->resource) }}" target="_blank">{{ e($snippet->resource) }}</a></p>
			@endif

			<pre><code class="prettyprint linenums js-prettyprint">{{ e($snippet->body) }}</code></pre>

			<div class="snippet-share-links"
				<span class="st_facebook_hcount" displayText="Facebook"></span>
				<span class="st_twitter_hcount" displayText="Tweet" st_via="{{ Config::get('site.twitter_via') }}"></span>
				<span class="st_linkedin_hcount" displayText="LinkedIn"></span>
				<span class="st_googleplus_hcount" displayText="Google +"></span>
				<span class="st_tumblr_hcount" displayText="Tumblr"></span>
			</div>

			<div class="snippet-meta">

				@if ( count( $snippet->tags ) > 0 )

					<ul class="snippet-categories list-inline">
						<li>Categories:</li>
						@foreach ($snippet->tags as $tag)
							<li><a href="{{ route('tag.getShow', $tag->slug) }}">{{ e($tag->name) }}</a></li>
						@endforeach
					</ul>

				@endif

				<p>Submitted {{ $snippet->humanCreatedAt }}.<br>Updated {{ $snippet->humanUpdatedAt }}.</p>

			</div>

			@if ( App::environment() === 'production' )

				<div class="disqus">
					<div id="disqus_thread"></div>
					<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
					<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
				</div>

			@endif

		</div>

		@include('partials/sidebars/snippet')

	</div>

@stop

@section('scripts')

	@if ( App::environment() === 'production' )

		<script type="text/javascript">
			/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			var disqus_shortname = '{{ Config::get("disqus.shortname") }}'; // required: replace example with your forum shortname
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
