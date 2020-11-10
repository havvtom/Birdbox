<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;

class TaskTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_task_belongs_to_a_project()
    {
    	$task = Task::factory()->make();

    	$task->project()->associate(Project::factory()->create());

    	$this->assertInstanceOf(Project::class, $task->project);
    }

    public function test_it_has_a_path()
    {
    	$this->signIn();

    	$task = Task::factory()->make();

    	$task->project()->associate(Project::factory()->create());

    	$this->assertEquals($task->path(), $task->project->path(). '/tasks/'.$task->id);
    }

     public function test_task_can_be_completed()
    {
        $this->signIn();

        auth()->user()->projects()->save($project = Project::factory()->create());

        $task = $project->tasks()->create($attributes = Task::factory()->raw());

        $this->assertFalse($task->completed);

        $attributes['completed'] = true;

        $this->patch($task->path(), $attributes );

        $this->assertTrue($task->fresh()->completed);
    }

     public function test_task_can_be_incompleted()
    {
        $this->signIn();

        auth()->user()->projects()->save($project = Project::factory()->create());

        $task = $project->tasks()->create($attributes = Task::factory()->raw(['completed' => true]));

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
