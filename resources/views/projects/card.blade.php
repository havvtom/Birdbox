<div class="card" style="height: 200px;">
	<h3 class="text-xl py-6 -ml-5 border-l-4 border-blue-400 pl-5 mb-3">
		<a href="{{ route('projects.show', $project)  }}" class="text-gray-900">{{ $project->title }}</a>
	</h3>

	<div class="text-gray-500">{{  Illuminate\Support\Str::limit($project->description, 100) }}</div>
	@can('manage', $project)
	<footer class="mt-3">
		<form action="{{ route('projects.destroy', $project) }}" method="POST">
			@method('DELETE')
			@csrf
			<div class="flex justify-end">
				<button class="bg-red-500 text-white rounded-lg py-2 px-5">Delete</button>
			</div>
		</form>
	</footer>
	@endcan
</div>
