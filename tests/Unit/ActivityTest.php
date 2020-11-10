<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ActivityTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_an_activity_has_user()
    {
    	$this->withoutExceptionHandling();

    	$this->signIn();

    	$project = Project::factory()->create(['owner_id' => auth()->id()]);

    	$this->assertEquals(auth()->id(), $project->activity->first()->user->id);
    }
}
