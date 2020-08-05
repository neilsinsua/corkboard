<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function testA_project_has_a_path()
    {
        //Given a project exists
        $project = factory(Project::class)->create();
        //When calling the path method
        //Then it returns its path
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    public function testA_project_has_a_user()
    {
        //Given a user creates a project
        $project = factory(Project::class)->create();
        //When calling its user method
        //Then return its user
        $this->assertInstanceOf(User::class, $project->user);
    }
}
