<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_only_authenticated_users_can_create_projects()
    {
        //When a project is created and your not signed in
        $attributes = factory(Project::class)->raw();
        // Assert should redirect to login
        $this->post('/projects', $attributes)->assertRedirect('/login');
    }

    public function test_a_user_can_create_a_project()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user);
        $attributes = factory(Project::class)->raw(['user_id' => $user->id]);

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
        $this->actingAs(factory(User::class)->create());
        //Given a project exists
        $project = factory(Project::class)->create();
        //When we make a get request
        //Then we should see the project
        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);

    }

    public function test_a_project_requires_a_title()
    {
        $this->actingAs(factory(User::class)->create());
        $attributes = factory(Project::class)->raw(['title' => '']);
        //Action: when a post request is made without a title
        //Check: should throw a validation error
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    public function test_a_project_requires_a_description()
    {
        $this->actingAs(factory(User::class)->create());
        $attributes = factory(Project::class)->raw(['description' => '']);
        //Action: when a post request is made without a title
        //Check: should throw a validation error
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');

    }

}
