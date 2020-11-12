<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;

class ProjectTest extends TestCase
{
	use RefreshDatabase;

    public function test_a_project_has_a_path()
    {
    	$this->actingAs($user = User::factory()->create());

    	$project = Project::factory()->create(['owner_id' => $user->id]);

    	$this->get($project->path())->assertSee($project->title);
    }

    public function test_a_project_belongs_to_an_owner()
    {
    	$project = Project::factory()->create();

    	$this->assertInstanceOf(User::class, $project->owner);
    }

    public function test_it_can_add_a_task()
    {
        $this->signIn();
        
        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertTrue($project->tasks->contains($task));

        $this->assertCount(1, $project->tasks);
    }

    public function test_it_can_invite_a_user()
    {
        $project = Project::factory()->create();

        $project->invite($user = User::factory()->create());

        $this->assertTrue($project->members->contains($user));
    }
}
