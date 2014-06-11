@extends('layouts.master')

@section('content')

	<div class="row">

		<div class="col-md-9">

			<h2>Most Recent Snippets</h2>
			{{ HTML::snippets($snippets) }}

			<hr>

			<h2>Most Popular Snippets</h2>
			{{ HTML::snippets($mostViewedSnippets, false) }}

		</div>

		@include('partials/sidebars/default')

	</div>

@stop