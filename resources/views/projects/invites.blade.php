<div class="card my-4" >
	<h3 class="text-xl py-6 -ml-5 border-l-4 border-blue-400 pl-5 mb-2">
		<a href="{{ route('projects.show', $project) }}" class="text-gray-900">Invite a User</a>
	</h3>
	<form action="{{ route('invitations.store', $project) }}" method="POST">
		@csrf
		<div class="mb-4">
			<label for="email" class="sr-only">Email</label>
			<input 
				type="text" 
				name="email" 
				id="email"
				class="bg-gray-100 border-2 w-full px-4 py-2 rounded-lg @error('email') border-red-500 @enderror" 
				placeholder="Email address" 
			>
			@error('email')
				<div class="text-red-500 mt-2 text-xs">
					{{ $message }}
				</div>
			@enderror
		</div>
		<div class="flex justify-end">
			<button class="bg-blue-500 text-white rounded-lg py-2 px-5">Invite</button>
		</div>
	</form>
</div>