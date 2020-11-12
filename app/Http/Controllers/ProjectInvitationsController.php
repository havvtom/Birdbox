<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project, ProjectInvitationRequest $request)
    {
    	$user = User::where(['email' => $request->email])->first();

    	$project->invite($user);

    	return redirect($project->path());
    }
}
