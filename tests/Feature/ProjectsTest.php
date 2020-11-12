<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class ProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */    

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'notes' => 'General notes'
        ];

        $response = $this->post('projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee(\Illuminate\Support\Str::limit($attributes['description'], 100))
            ->assertSee($attributes['notes']);
    }

    public function test_a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $this->patch($project->path(), $attributes = ['description' => 'changing for testing','title' => 'title has changed', 'notes' => 'More general notes'])->assertRedirect($project->path());

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_a_user_can_delete_a_project()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->signIn($project->owner)->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_guests_cannot_delete_projects()
    {
        $project = Project::factory()->create();

        $this->delete($project->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);
    }

    public function test_a_user_can_update_general_notes()
    {
        $this->withoutExceptionHandling();
        
        $this->signIn();

        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $this->patch($project->path(), $attributes = ['notes' => 'changed']);

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path(), ['notes' => 'changed'])->assertStatus(403);
    }

    public function test_a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('projects', $attributes)->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->user()->id]);

        $this->get($project->path())
         ->assertSee($project->title);
    }

    public function test_an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())
         ->assertStatus(403);
    }

    public function test_guests_cannot_view_a_single_project()
    {
        $project = Project::factory()->create();

        $this->get($project->path())->assertRedirect('login');
    }

    public function test_guests_cannot_create_projects()
    {
        $this->get('projects/create')->assertRedirect('login');
        $attributes = Project::factory()->raw();

        $this->post('projects', $attributes)->assertRedirect('login');
    }

    public function test_guests_may_not_view_projects()
    {
        $this->get('projects')->assertRedirect('login');
    }

    public function test_a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $project->invite(auth()->user());

        $this->get('projects')->assertSee($project->title);
    }
}
