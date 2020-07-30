<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use MyDomain\Application\User\UserApplicationService;
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
        // Repositoryでテストしてるから、このレイヤーでdatabase検証は微妙な気がする
        // Application層では、RepositoryをInMemoryとかに置き換えればいいのかな
        // でもphpUnitのレイヤーでmemoryになってるんだよね
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
        $fetchedUser = $this->application->get($createdUser->id);
        $this->assertInstanceOf('MyDomain\Dto\UserData', $fetchedUser);
    }

    public function test_update_user()
    {
        $createdUser = $this->application->register('updateMan', 'd@d.com');
        $this->application->update($createdUser->id, 'changed');
        $this->assertDatabaseHas('users', ['name' => 'changed', 'email' => 'd@d.com']);
    }

    public function test_may_not_update_duplicate_user()
    {
        $this->expectExceptionMessage('user already exists');
        $createdUser = $this->application->register('updateMan', 'd@d.com');
        // 変更後のメールアドレスに同じものをいれる
        $this->application->update($createdUser->id, 'changed', 'd@d.com');
    }

    public function test_update_non_existent_user_throw_exception()
    {
        $this->expectExceptionMessage('user does not exists');
        $this->application->update('non_existent_user_id', 'changed');
    }
}
