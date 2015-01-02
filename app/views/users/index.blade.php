@extends('layouts.master')

@section('content')

	<div class="band">
		<div class="user-profiles-wrapper">

			<h4 class="heading">Members:</h4>

			@if ($users->count())

				<ul class="list-unstyled">

					@foreach ($users as $user)

						<li class="profile">
							<div class="row">

								<div class="col-md-2">
									<img src="{{ $user->abs_photo_url }}" class="profile-pic" height="120" width="120">
								</div>

								<div class="col-md-10">
									<a href="{{ route('user.getProfile', $user->slug) }}">
										<h4 class="name">{{ $user->full_name }}</h4>
									</a>

									@if($user->about_me)
										<p>{{ Str::limit($user->about_me, 180) }}</p>
									@endif

									<a href="{{ route('user.getSnippets', $user->slug) }}">
										<p>Submitted snippets: {{ $user->snippets_count }}</p>
									</a>

								</div>

							</div>
						</li>

					@endforeach

				</ul>

				{{ $users->links() }}

			@else

				<p>No site members yet.</p>

			@endif


		</div>
	</div>

@stop
