<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}">
			{{ config('app.name', 'Laravel') }}
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<form class="form-inline" method="get" action="{{ url('search') }}">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="term" value="{{ Request::get('term') }}">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
			<!-- Left Side Of Navbar -->
			<ul class="navbar-nav mr-auto">

			</ul>

			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
				@guest
				<li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
				<li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
				@else
					<a class="btn btn-outline-primary my-2 my-sm-0"href="{{ url('video/upload') }}">Upload</a>
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							{{ Auth::user()->name }} <span class="caret"></span>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ url('videos') }}">Your videos</a>
							<a class="dropdown-item" href="{{ url('channels/' . $channel->slug . '/show') }}">Your channel</a>
							<a class="dropdown-item" href="{{ url('channels/' . $channel->slug . '/edit') }}">Channel settings</a>
							<a class="dropdown-item" href="{{ route('logout') }}"
							   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
					@endguest
			</ul>
		</div>
	</div>
</nav>