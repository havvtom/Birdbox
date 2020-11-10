<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_creating_a_project_records_an_activity()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertNull($activity->changes);
            $this->assertEquals($activity->description,'project_created');
        });
        
    }

    public function test_updating_a_project_records_an_activity()
    {
        $project = Project::factory()->create();

        $originalTitle = $project->title;

        $project->update(['title' => 'title changed']);

        $this->assertCount(2, $project->activity);        

        tap($project->activity->last(), function ($activity) use($originalTitle) {
            $this->assertEquals($activity->description,'project_updated');
            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'title changed']
            ];
            $this->assertEquals($expected, $activity->changes);
        });
    }

    public function test_creating_a_new_task_records_a_project_activity()
    {
        $project = Project::factory()->create();

        $project->addTask('new task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity){          
            $this->assertEquals($activity->description, 'task_created'); 
            $this->assertInstanceOf(Task::class, $activity->subject); 
        });
    }

    public function test_completing_a_task_records_activity()
    {
        $this->withoutExceptionHandling();
        
        $project = Project::factory()->create();

        $task = $project->tasks()->create($attributes = Task::factory()->raw(['completed' => true]));

        $this->actingAs($project->owner)->patch($task->path(), $attributes);

        $this->assertCount(3, $project->activity);

        tap( $project->activity->last(), function($activity) {
            
            $this->assertEquals($activity->description, 'task_completed');
            $this->assertInstanceOf(Task::class, $activity->subject); 
        });

        
    }

    public function test_incompleting_a_task_records_activity()
    {
        $project = Project::factory()->create();

        $task = $project->tasks()->create($attributes = Task::factory()->raw(['completed' => true]));

        $this->actingAs($project->owner)->patch($task->path(), $attributes);

        $this->assertCount(3, $project->activity);

        $this->actingAs($project->owner)->patch($task->path(), ['body' => $task->body, 'completed' => 'false']);

        $this->assertCount(4, $project->fresh()->activity);
    }

    public function test_deleting_a_task_triggers_activity()
    {
        $this->withoutExceptionHandling();
        
        $project = Project::factory()->create();

        $task = $project->tasks()->create(Task::factory()->raw());

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
