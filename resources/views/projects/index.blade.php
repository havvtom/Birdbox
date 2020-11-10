@extends('layouts.app')

@section('content')
	<header class="mb-6 py-4">
		<div class="flex justify-between items-center">
			<h3
				class="text-gray-500" 
			>
				My Projects
			</h3>
			<a 
				href="/projects/create"
				class="button"
			>
				Create new Project
			</a>
		</div>
	</header>
	
	<main class="lg:flex lg:flex-wrap -mx-3">
		@forelse($projects as $project)
			<div class="lg:w-1/3 px-3 pb-6">
				@include('projects.card')
			</div>
			@empty
			<div>
				No projects yet.
			</div>
		@endforelse
	</main>	
@endsection