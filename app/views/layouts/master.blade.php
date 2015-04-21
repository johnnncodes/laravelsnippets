<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="/">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
		<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
		<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-touch-icon-57x57.png') }}">
		<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-touch-icon-60x60.png') }}">
		<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-touch-icon-72x72.png') }}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-touch-icon-76x76.png') }}">
		<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-touch-icon-114x114.png') }}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-touch-icon-120x120.png') }}">
		<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-touch-icon-144x144.png') }}">
		<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-touch-icon-152x152.png') }}">

		@section('title')
			<title>{{ Config::get('site.title') }}</title>
		@show

		@section('meta_description')
			<meta name="description" content="{{ Config::get('site.meta_description') }}">
		@show

		@section('meta_author')
			<meta name="author" content="{{ Config::get('site.meta_author') }}">
		@show

		<!-- Google Web Fonts -->
		{{ HTML::style('//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700') }}

		<!-- Bootstrap core CSS -->
		{{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css') }}

		<!-- FontAwesome core CSS -->
		{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') }}

		<!-- Code mirror css -->
		{{ HTML::style( asset('packages/codemirror-3.19/lib/codemirror.css') ) }}
		{{ HTML::style( asset('packages/codemirror-3.19/theme/monokai.css') ) }}

		<!-- Google code prettify css -->
		{{ HTML::style( asset('packages/google-code-prettify/prettify.css') ) }}

		<!-- Chosen.js css -->
		{{ HTML::style( asset('packages/chosen_v1.0.0/chosen.min.css') ) }}

		<!-- Custom styles for this template -->
		{{ HTML::style( asset('assets/css/styles.css') ) }}

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			{{ HTML::script('//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}
			{{ HTML::script('//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js') }}
		<![endif]-->

		@if ( App::environment() === 'production' )

			<!-- Google analytics script -->
			<script>
				(function (i,s,o,g,r,a,m) {i['GoogleAnalyticsObject']=r;i[r]=i[r]||function () {
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', '{{ Config::get('site.ga_code') }}', '{{ Config::get('site.url_short') }}');
				ga('send', 'pageview');
			</script>

		@endif

	</head>

	<body id="{{ SiteHelpers::bodyId() }}" class="{{ SiteHelpers::bodyClass() }}">

		@include('partials/header')

		<div class="container">
			<div id="content">

				@include('partials/notifications')

				@yield('content')

			</div>
		</div>

		@include('partials/footer')

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		{{ HTML::script( asset('assets/js/vendors/jquery.min.js') ) }}
		{{ HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js') }}

		<!-- Codemirror javascript -->
		{{ HTML::script( asset('packages/codemirror-3.19/lib/codemirror.js') ) }}
		{{ HTML::script( asset('packages/codemirror-3.19/mode/clike/clike.js') ) }}
		{{ HTML::script( asset('packages/codemirror-3.19/mode/php/php.js') ) }}

		<!-- Google code prettify javascript -->
		{{ HTML::script( asset('packages/google-code-prettify/prettify.js') ) }}

		<!-- Chosen.js javascript -->
		{{ HTML::script( asset('packages/chosen_v1.0.0/chosen.jquery.min.js') ) }}

		<!-- App specific javascript -->
		{{ HTML::script( asset('assets/js/common.js') ) }}
		{{ HTML::script( asset('assets/js/snippet.js') ) }}

		<!--ShareThis Plugin-->
		{{ HTML::script('//w.sharethis.com/button/buttons.js') }}
		<script type="text/javascript">
			stLight.options({
				publisher: "b1eb8f86-ebb5-408b-9cb8-0a08b830b3c7",
				doNotHash: false,
				doNotCopy: false,
				hashAddressBar: false
			});
		</script>

		@section('scripts')
		@show

	</body>
</html>