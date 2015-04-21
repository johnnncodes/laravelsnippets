<div class="navbar navbar-default" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/ls_brand_logo.png') }}"
                     height="40"
                     alt="{{ Config::get('site.name') }}"></a>
        </div>

        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ route('snippet.getIndex') }}">SNIPPETS</a>
                </li>
                <li><a href="{{ route('user.getIndex') }}">MEMBERS</a></li>
                @if(Auth::check())
                    <li><a href="{{ route('member.snippet.getCreate') }}" class="btn">SUBMIT SNIPPET</a></li>
                    <li>
                        <img src="{{ Auth::user()->abs_photo_url }}" height="50" width="50" style="border-radius: 50%">
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{Auth::user()->full_name}}
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->isAdmin())
                                <li><a href="{{route('admin.index')}}">ADMIN</a></li>
                            @endif
                            <li><a href="{{ route('member.user.dashboard') }}">DASHBOARD</a></li>
                            <li><a href="{{route('user.getSettings', Auth::user()->slug)}}">SETTINGS</a></li>
                            <li><a href="{{ route('auth.getLogout') }}">SIGN OUT</a></li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route('auth.getLogin') }}" class="btn">SIGN IN</a>
                    </li>
                @endif
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