@extends('layouts.master')

@section('content')

	<div class="band">
		<h1>Roadmap</h1>
		<p>OK, you're right, you've found a placeholder page. Dull right?</p>
		<p>Actually, this page is an addition to resolve GitHub issue <a href="//github.com/basco-johnkevin/laravelsnippets/issues/52">Roadmap</a>, because we have plans to do bigger and better with {{{ Config::get('site.name') }}}, in part to serve as an example app and also to provide the web with a home for useful Laravel code snippets to speed up your development and help you to improve your code. We'll update this page soon with super interesting insight (for geeks) to see where we're going with this site and also for you to get involved, if you're geek enough of course. ;)</p>
		<p>If you'd like to get involved, check out the <a href="{{{ Config::get('site.repo_url') }}}" target="_blank">{{{ Config::get('site.name') }}} GitHub repo</a> and feel free to improve and submit pull requests!</p>
	</div>

@stop