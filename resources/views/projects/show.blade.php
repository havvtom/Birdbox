@extends('layouts.app')

@section('content')
	<header class="mb-6 py-4">
		<div class="flex justify-between items-center">
			<p
				class="text-gray-500" 
			>
				<a href="/projects">My Projects</a>/{{ $project->title }}
			</p>
			<a 
				href="{{ route('projects.edit', $project) }}"
				class="button"
			>
				Edit Project
			</a>
		</div>
	</header>
	<main>
		<div class="lg:flex -mx-3">
			<div class="lg:w-3/4 px-3">
				<div class="mb-6">
					<h2 class="text-gray-500 font-normal text-lg mb-3">Tasks</h2>
					@foreach($project->tasks as $task)
						<div class="card mb-3">
							<form action="{{ route('tasks.update', [$project->id, $task->id])}}" method="post">
								@method('PATCH')
								@csrf
								<div class="flex">
									<input type="text" name="body" value="{{ $task->body }}" class="w-full  {{ $task->completed ? 'text-gray-500' : '' }}" />
									<input type="checkbox" name="completed" onChange="this.form.submit()"
									{{ $task->completed ? 'checked' : '' }}>
								</div>
							</form>
						</div>						
					@endforeach
					<div class="card mb-3">
						<form action="{{ route('tasks.store', $project->id) }}" method="post">
							@csrf
							<input name="body" placeholder="Add tasks..." class="w-full">
						</form>
					</div>
				</div>
				<div>
					<h2 class="text-gray-500 font-normal text-lg mb-3">General Notes</h2>
					<form action="{{ route('projects.update', $project->id) }}" method="POST">
						@method('PATCH')
						@csrf
						<textarea 
							name="notes"
							class="card w-full" 
							style="min-height: 100px;"
							placeholder="Anything special you want to take note of?"
							>{{ $project->notes }}
						</textarea>
						<button class="button">Save</button>
					</form>
				</div>
			</div>
			<div class="lg:w-1/4 px-3">
				@include('projects.card')

				@include('projects.activity')
			</div>			
		</div>
	</main>
@endsection