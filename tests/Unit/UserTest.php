<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;

class UserTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_has_projects()
    {
    	$this->actingAs($user = User::factory()->create());

    	$user->projects()->save(Project::factory()->create());

    	$this->assertEquals(1, $user->projects->count());
    }

    public function test_a_user_has_accessible_projects()
    {
        $john = User::factory()->create(['name' => 'John']);

        $project = Project::factory()->create(['owner_id'=>$john->id]);

        $this->assertCount(1, $john->accessibleProjects());

        $project2 = Project::factory()->create(['owner_id' => $sally = User::factory()->create()]);

        $project2->invite($john);

        $nick = User::factory()->create();

        $project2->invite($nick);

        $this->assertCount(2, $john->fresh()->accessibleProjects());
    }
}
