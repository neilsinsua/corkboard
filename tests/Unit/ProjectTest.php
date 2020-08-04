<?php

namespace Tests\Unit;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_path()
    {
        //Given I have a project
        $project = factory(Project::class)->create();
        //When calling a path method
        //Then assert it returns a http request to its path
        $this->assertEquals('/projects/' . $project->id, $project->path());

    }
}
