<div class="navbar navbar-default" role="navigation">
	<div class="container">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/images/ls_brand_logo.png') }}" height="40" alt="{{ Config::get('site.name') }}"></a>
		</div>

		<div class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">SNIPPETS <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('snippet.getIndex') }}">View all</a></li>
						<li><a href="{{ route('member.snippet.getCreate') }}">Submit</a></li>
					</ul>
				</li>

				@if(Auth::check())
					<li><a href="{{ route('member.user.dashboard') }}">DASHBOARD</a></li>
				@endif

				<li><a href="{{ route('user.getIndex') }}">MEMBERS</a></li>

				@if(Auth::check() && Auth::user()->isAdmin())
					<!-- <li><a href="#">All Snippets</a></li> -->
				@endif

				@if(Auth::check())
					<li>
						<!--<li><a href="#">Profile</a></li>-->
						<a href="{{ route('auth.getLogout') }}">SIGN OUT</a>
					</li>
				@else
					<li>
						<a href="{{ route('auth.getLogin') }}">SIGN IN</a>
					</li>
				@endif

				<li><a href="{{ route('member.snippet.getCreate') }}" class="btn">SUBMIT</a></li>

			</ul>

		</div>

	</div>
</div>

@if ( Request::is('/') )
	@include('partials/search')
@else
	@include('partials/search-narrow')
	{{ SiteHelpers::breadcrumbs() }}
@endif