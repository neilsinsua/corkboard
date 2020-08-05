<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_show_their_projects()
    {
        $this->withoutExceptionHandling();
        //Given a user has created several projects
        $user = factory(User::class)->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
