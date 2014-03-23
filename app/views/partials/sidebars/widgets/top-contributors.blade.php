@if ( count( $topSnippetContributors ) > 0 )

	<div class="sidebar-widget widget-contributors">
		<h4>Top 5 Snippet Contributors</h4>
		<ul>
			@foreach ($topSnippetContributors as $contributor)
				<li class="contributor">
					<a href="{{ route('user.getProfile', $contributor->slug) }}">{{ $contributor->full_name }}</a>
					<a href="{{ route('user.getSnippets', $contributor->slug) }}" class="snippet-count">{{ $contributor->snippets_count }}</a>
				</li>
			@endforeach
		</ul>
	</div>

@endif