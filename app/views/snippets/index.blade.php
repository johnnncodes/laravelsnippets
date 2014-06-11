@extends('layouts.master')

@section('content')

	<div class="row">

		<div class="col-md-9">
			<h1>All Snippets</h1>
			{{ HTML::snippets($snippets) }}
		</div>

		@include('partials/sidebars/default')

	</div>

@stop