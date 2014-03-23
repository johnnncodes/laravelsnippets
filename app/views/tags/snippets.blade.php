@extends('layouts.master')

@section('content')

	<div class="row">

		<div class="col-md-9">
			<h1>{{ substr( $tag->name, -1 ) === 's' ? e( substr( $tag->name, 0, -1 ) ) : e( $tag->name ) }} Snippets</h1>
			{{ HTML::snippets($snippets) }}
		</div>

		@include('partials/sidebars/default')

	</div>

@stop
