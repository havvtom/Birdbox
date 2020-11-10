@extends('layouts.app')

@section('content')
<div class="flex justify-center">
	<div class="w-8/12 bg-white p-6 rounded-lg">
		@if(session('status'))
			<div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
				{{ session('status') }}
			</div>
		@endif
		<form action="{{ route('projects.update', $project->id) }}" method="post">
			@csrf
			@method('PATCH')
			<div class="text-gray-700 text-4xl mb-6 text-center">
				Edit your project
			</div>
			<div class="mb-4">
				<label for="title" class="sr-only">Project Title</label>
				<input 
					type="text" 
					name="title" 
					id="title"
					class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('title') border-red-500 @enderror" 
					placeholder="Enter the project title" 
					value="{{ $project->title ?: old('title') }}"
				>
				@error('title')
					<div class="text-red-500 mt-2 text-xs">
						{{ $message }}
					</div>
				@enderror
			</div>
			<div class="mb-4">
				<label for="description" class="text-gray-700 text-xl">Description</label>
				<textarea
					type="text" 
					name="description" 
					id="description"
					class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('description') border-red-500 @enderror" 
					placeholder="Your description" 
				>{{ $project->description ?: old('description') }}
				</textarea> 
				@error('description')
					<div class="text-red-500 mt-2 text-xs">
						{{ $message }}
					</div>
				@enderror
			</div>
			<div class="flex justify-between">
				<button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-5/12">
					Update Project
				</button>

				<a href="{{ route('projects.show', $project->id) }}" class="bg-blue-500 text-white text-center px-4 py-3 rounded font-medium w-5/12">
					Cancel
				</a>

			</div>
		</form>
	</div>
</div>
@endsection