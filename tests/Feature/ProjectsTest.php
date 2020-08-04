<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $attributes = factory(Project::class)->raw();

        //Action: a post request is made to projects
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        //Check: Database should have that project
        $this->assertDatabaseHas('projects', $attributes);

        //Action: a get request is made to projects
        //Check: I can see the project in the response
        $this->get('/projects')->assertSee($attributes['title']);

    }

    public function test_a_user_can_view_a_project()
    {
        $this->withoutExceptionHandling();
        //Given a project exists
        $project = factory(Project::class)->create();
        //When we make a get request
        //Then we should see the project
        $this->get('/projects/' . $project->id)->assertSee($project->title)->assertSee($project->description);

    }

    public function test_a_project_requires_a_title()
    {

        $attributes = factory(Project::class)->raw(['title' => '']);
        //Action: when a post request is made without a title
        //Check: should throw a validation error
        $this->post('/projects', [])->assertSessionHasErrors('title');

    }

    public function test_a_project_requires_a_description()
    {
        $attributes = factory(Project::class)->raw(['description' => '']);
        //Action: when a post request is made without a title
        //Check: should throw a validation error
        $this->post('/projects', [])->assertSessionHasErrors('description');

    }
}
