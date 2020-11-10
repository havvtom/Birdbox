@extends('layouts.app')

@section('content')
<div class="flex justify-center">
	<div class="w-5/12 bg-white p-6 rounded-lg">
		<form action="{{ route('register.store') }}" method="post">
			@csrf
			<div class="mb-4">
				<label for="name" class="sr-only">Name</label>
				<input 
					type="text" 
					name="name" 
					id="name"
					class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" 
					placeholder="Your name" 
					value="{{ old('name') }}"
				>
				@error('name')
					<div class="text-red-500 mt-2 text-xs">
						{{ $message }}
					</div>
				@enderror
			</div>
			<div class="mb-4">
				<label for="email" class="sr-only">Email</label>
				<input 
					type="text" 
					name="email" 
					id="email"
					class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('email') border-red-500 @enderror" 
					placeholder="Your email address" 
					value="{{ old('email') }}"
				>
				@error('email')
					<div class="text-red-500 mt-2 text-xs">
						{{ $message }}
					</div>
				@enderror
			</div>
			<div class="mb-4">
				<label for="password" class="sr-only">Password</label>
				<input 
					type="password" 
					name="password" 
					id="password"
					class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password') border-red-500 @enderror" 
					placeholder="Your password" 
				>
				@error('password')
					<div class="text-red-500 mt-2 text-xs">
						{{ $message }}
					</div>
				@enderror
			</div>
			<div class="mb-4">
				<label for="password_confirmation" class="sr-only">Confirm Password</label>
				<input 
					type="password" 
					name="password_confirmation" 
					id="password_confirmation"
					class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password_confirmation') border-red-500 @enderror" 
					placeholder="Confirm your password" 					
				>
				@error('password_corfirmation')
					<div class="text-red-500 mt-2 text-xs">
						{{ $message }}
					</div>
				@enderror
			</div>
			<div>
				<button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">
					Register
				</button>
			</div>
		</form>
	</div>
</div>
@endsection