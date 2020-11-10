<!DOCTYPE html>
<html>
<head>
	<title>Laravel Auth</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css')}}">
</head>
<body class="bg-gray-100">
	<nav class="p-6 bg-white flex justify-between">
		<ul class="flex">
			<li class="p-3">
				Home
			</li>
			<li class="p-3">
				<a href="{{ route('dashboard') }}">
					Dashboard
				</a>
			</li>
		</ul>
		<ul class="flex">			
			@auth
				<li class="p-3">
					{{ auth()->user()->name }}
				</li>
				<li class="p-3">
					<form action="{{ route('logout') }}" method="post" class="p-3 inline">
						@csrf
						<button type="submit" >
							Logout
						</button>
					</form>
				</li>
			@endauth
			@guest
				<li class="p-3">
					<a href="{{ route('register.create') }}">
						Register
					</a>
				</li>
				<li class="p-3">
					<a href="{{ route('login') }}">
						Login
					</a>
				</li>
			@endguest
		</ul>
	</nav>
	<div class="container mx-auto mt-6">
		@yield('content')
	</div>
</body>
</html>