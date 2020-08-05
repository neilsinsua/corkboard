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
    //Assumptions
    //1. All users must be authenticated
    //2. Creators of a project are known as users

    public function testUnauthenticated_users_cant_create_projects()
    {
        // When a project is created and your not signed in
        $attributes = factory(Project::class)->raw();
        // Then redirect to login
        $this->post('/projects', $attributes)->assertRedirect('/login');
    }

    public function testUnauthenticated_users_cant_view_projects()
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create();
        // When not logged in
        // Then redirect to login page
        $this->get($project->path())->assertRedirect('login');
        $this->actingAs($user);
        // When logged in but not authorized
        // Then return forbidden
        $this->get($project->path())->assertForbidden();
    }

    public function testA_user_can_create_a_project()
    {
        $user = factory(User::class)->create();
        //Given a user is logged in
        $this->actingAs($user);
        //And they create a project
        $attributes = factory(Project::class)->raw(['user_id' => $user->id]);
        //When a post request is made to projects
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        //Then the Database has that project
        $this->assertDatabaseHas('projects', $attributes);
    }

    public function testA_user_can_view_their_projects()
    {
        $user = factory(User::class)->create();
        //Given a user is logged in
        $this->actingAs($user);
        //Given they create a project
        $project = factory(Project::class)->create(['user_id' => $user->id]);
        //When they make a get request to projects
        //Then they can see all their projects
        $this->get('/projects')->assertSee($user->projects);
        //When they make a get request to the project they created
        //Then they will see a that project
        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }

    public function testA_project_requires_a_title()
    {
        $this->actingAs(factory(User::class)->create());
        $attributes = factory(Project::class)->raw(['title' => '']);
        //When a post request is made without a title
        //Then throw a validation error
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function testA_project_requires_a_description()
    {
        $this->actingAs(factory(User::class)->create());
        $attributes = factory(Project::class)->raw(['description' => '']);
        //When a post request is made without a description
        //Then throw a validation error
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

}
