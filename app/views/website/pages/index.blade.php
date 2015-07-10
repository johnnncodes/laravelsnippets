@extends('layouts.master')

@section('content')

	<div class="band">
		<div class="row">

			<div class="col-md-9">

				<a href="http://tutsbucket.com/kemh" target="_blank">
				    <img src="{{ asset('assets/images/glee-help-desk-software.png') }}" alt="Glee Help Desk" class="img-responsive" style="max-height: 125px; display: block; margin: auto; padding-bottom: 30px;">
				</a>

				<h2>Most Recent Snippets</h2>
				{{ HTML::snippets($snippets) }}

				<hr>

				<h2>Most Popular Snippets</h2>
				{{ HTML::snippets($mostViewedSnippets, false) }}

			</div>

			@include('partials/sidebars/default')

		</div>
	</div>

@stop
