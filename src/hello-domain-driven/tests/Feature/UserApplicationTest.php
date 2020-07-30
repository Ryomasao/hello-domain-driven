<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use MyDomain\Application\UserApplicationService;
use MyDomain\Services\UserService;
use MyDomain\Repositories\UserRepository\UserEloquentRepository;

// Note
// Domain層のUserApplication
// MyDomain配下にtestsを置く方がいい気がする
// その場合、Eloquentに依存してる箇所とかはLaravelのTestCaseをextendsしたほうがいいのかな

class UserApplicationTest extends TestCase
{
    use RefreshDatabase;

    private UserApplicationService $application;

    public function setup(): void
    {
        parent::setup();

        $repository = new UserEloquentRepository;
        $userService = new UserService($repository);
        $this->application = new UserApplicationService($repository, $userService);
    }

    public function test_create_user()
    {
        $this->application->register('tarou', 'a@a.com');
        $this->assertDatabaseHas('users', ['name' => 'tarou', 'email' => 'a@a.com']);
    }

    public function test_may_not_create_duplicate_user()
    {
        $this->expectExceptionMessage('user already exists');
        $this->application->register('jirou', 'b@b.com');
        $this->application->register('jirou', 'b@b.com');
    }

    public function test_get_user()
    {
        $createdUser = $this->application->register('savedMan', 'c@c.com');
        $fetchedUser = $this->application->get($createdUser->id()->value());
        $this->assertInstanceOf('MyDomain\Entities\User', $fetchedUser);
    }
}
