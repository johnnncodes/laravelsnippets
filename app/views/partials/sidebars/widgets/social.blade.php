<div class="sidebar-widget widget-social">
	<h4>Get Involved</h4>
	<p><a href="{{ route('home') }}">{{ Config::get('site.name') }}</a> is an <strong>open source</strong>, <strong>community driven project</strong> that aims to provide a resource for learning and a repository of useful snippets to speed up development.</p>
	<p>Getting involved is easy, you can either contribute towards the site's code by forking the <a href="{{ Config::get('site.repo_url') }}">github repo</a> or <a href="{{ route('member.snippet.getCreate') }}">submit your own useful code snippets</a>.</p>
	<p>Follow us for new snippets, other useful resources that we find from time to time and of course to chat - see you there!</p>
	<ul class="widget-social-icons">
		<li><a href="{{ Config::get('site.twitter_url') }}" target="_blank" class="twitter" title="{{ '@' . Config::get('site.twitter_username') }} on Twitter"><i class="fa fa-twitter"></i></a></li>
		<li><a href="{{ Config::get('site.facebook_url') }}" target="_blank" class="facebook" title="{{ Config::get('site.facebook_username') }} on Facebook"><i class="fa fa-facebook"></i></a></li>
	</ul>
</div>