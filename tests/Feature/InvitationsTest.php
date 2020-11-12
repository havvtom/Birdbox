<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $user = User::factory()->create();

        $this->signIn($project->owner)->post($project->path().'/invitations', [
            'email' => $user->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($user));
    }

    public function test_invited_email_must_be_associated_with_valid_birdboard_account()
    {
        $project = Project::factory()->create();

        $this->signIn($project->owner)->post($project->path().'/invitations', [
            'email' => 'notexist@email.com'
        ])->assertSessionHasErrors(['email' => 'The user you are inviting must have a birdboard account']);
    }

    public function test_non_owners_cannot_invite_other_users()
    {

        $project = Project::factory()->create();

        $user = User::factory()->create();

        $this->signIn()->post($project->path().'/invitations', [ 'email' => $user->email] )
            ->assertStatus(403);

        $project->invite($user);

        $this->signIn($user)->post($project->path().'/invitations', [ 'email' => $user->email] )
            ->assertStatus(403);

    }
    
    public function test_an_invited_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $project->invite( $newUser = User::factory()->create() );

        $this->signIn($newUser);

        $this->post($project->path().'/tasks', $task = ['body' => 'a']);

        $this->assertDatabaseHas('tasks', $task);
    }

    public function test_an_invited_user_cannot_delete_a_project()
    {
        $project = Project::factory()->create();

        $shavv = User::factory()->create();

        $project->invite($shavv);

        $this->signIn($shavv);

        $this->delete($project->path())->assertStatus(403);
    }
}
