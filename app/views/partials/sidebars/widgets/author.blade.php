<div class="sidebar-widget widget-author">

	<h4><a href="{{ route('user.getProfile', $snippet->author->slug) }}">{{ e($snippet->author->full_name) }}</a></h4>
	<img src="{{ $snippet->author->abs_photo_url }}" height="80" width="80" class="widget-author-avatar">

	<hr>

	<ul class="widget-author-stats">
		<li>Snippets<a href="{{ route('user.getSnippets', $snippet->author->slug) }}">{{ $snippet->author->snippets_count }}</a></li>
		<li>Stars<span>-</span></li>
		<li>Views<span>-</span></li>
	</ul>

	<hr>

	<ul class="widget-social-icons">

		<li><a href="{{ route('user.getProfile', $snippet->author->slug) }}"><i class="fa fa-user"></i></a></li>

		@if ( ! empty( $snippet->author->facebook_url ) )
			<li><a rel="nofollow" href="{{ $snippet->author->facebook_url }}" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a></li>
		@endif

		@if ( ! empty( $snippet->author->twitter_url ) )
			<li><a rel="nofollow" href="{{ $snippet->author->twitter_url }}" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a></li>
		@endif

		@if ( ! empty( $snippet->author->github_url ) )
			<li><a rel="nofollow" href="{{ $snippet->author->github_url }}" target="_blank" class="github"><i class="fa fa-github"></i></a></li>
		@endif

		@if ( ! empty( $snippet->author->website_url ) )
			<li><a href="{{ $snippet->author->website_url }}" target="_blank"><i class="fa fa-globe"></i></a></li>
		@endif
	</ul>

</div>