@if ( count( $tags ) > 0 )

	<div class="sidebar-widget widget-categories">
		<h4>Categories</h4>
		<ul>
			@foreach ( $tags as $tag )
				<li class="category"><a href="{{ route('tag.getShow', $tag->slug) }}">{{ e($tag->name) }}</a></li>
			@endforeach
		</ul>
	</div>

@endif