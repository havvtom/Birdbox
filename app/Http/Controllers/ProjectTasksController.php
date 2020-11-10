<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class ProjectTasksController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function store(Project $project, Request $request)
    {
    	$this->authorize('update', $project);

    	$request->validate([
    		'body' => 'required'
    	]);

    	$project->addTask($request->body);

    	return redirect($project->path());
    }

    public function update(Project $project, Task $task, Request $request)
    {
    	$this->authorize('update', $project);

        $attributes = $request->validate([
            'body' => 'required'
        ]);

    	$task->update($attributes);

        $method = $request->completed ? 'complete' : 'incomplete' ;

        $task->$method();

    	return redirect($project->path());
    }
}
