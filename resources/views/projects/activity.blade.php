<div class="card mt-3">
	<ul class="text-sm">
		@foreach($project->activity as $activity)
			<li>
				@include("projects.activity.{$activity->description}") {{ $activity->created_at->diffForHumans() }}
			</li>							
		@endforeach
	</ul>
</div>