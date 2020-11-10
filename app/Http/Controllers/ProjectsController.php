<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\UpdateFormRequest;

class ProjectsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
    	$projects = auth()->user()->projects;

		return view('projects.index', compact('projects'));
    }

    public function create()
    {
    	return view('projects.create');
    }

    public function store(Request $request)
    {
    	$attributes = $request->validate([
    		'title' => 'required',
    		'description' => 'required',
            'notes' => 'min: 3'
    	]);

    	$project = auth()->user()->projects()->create($attributes);

    	return redirect($project->path());
    }

    public function show(Project $project)
    {
    	$this->authorize('update', $project);

    	return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project, UpdateFormRequest $request)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('update', $project);
        
        $project->delete();

        return redirect('/projects');
    }
}
