<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guests_cannot_add_tasks()
    {
        $project = Project::factory()->create();

        $attributes = Task::factory()->raw();

        $this->post($project->path(). "/tasks", $attributes)->assertRedirect('login');
    }

    public function test_only_the_project_owner_can_add_a_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $attributes = Task::factory()->raw();

        $this->post($project->path() . "/tasks", $attributes)
            ->assertStatus(403);
            
        $this->assertDatabaseMissing('tasks', $attributes);
    }
    public function test_only_the_project_owner_can_update_a_task()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $task = $project->addTask('New testing task');

        $this->patch($task->path(), ['body' => 'task changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'task changed']);
    }

    public function test_a_project_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $task = $project->addTask('test task');

        $this->patch($project->path().'/tasks/'.$task->id, $attributes = ['body' => 'changed']);

        $this->assertDatabaseHas('tasks', $attributes);

    }

    public function test_a_project_task_can_be_completed()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $task = $project->addTask('test task');

        $this->patch($project->path().'/tasks/'.$task->id, $attributes = ['body' => 'changed', 'completed' => true]);

        $this->assertDatabaseHas('tasks', $attributes);

    }

    public function test_a_project_task_can_be_marked_as_incompleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $task = $project->addTask('test task');

        $this->patch($project->path().'/tasks/'.$task->id, $attributes = ['body' => 'changed', 'completed' => true]);

        $this->assertDatabaseHas('tasks', $attributes);

        $this->patch($project->path().'/tasks/'.$task->id, $attributes = ['body' => 'changed', 'completed' => false]);

        $this->assertDatabaseHas('tasks', $attributes);

    }

    public function test_a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->post($project->path() . "/tasks", ['body' => 'Test Task']);

        $this->get($project->path())->assertSee('Test Task');
    }

    public function test_a_task_requires_a_body()
    {

        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
   
}

