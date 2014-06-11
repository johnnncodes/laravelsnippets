@extends('layouts.master')

@section('content')

	<h1>{{ e($user->full_name) }}'s Snippets</h1>
	{{ HTML::snippets($snippets) }}

@stop