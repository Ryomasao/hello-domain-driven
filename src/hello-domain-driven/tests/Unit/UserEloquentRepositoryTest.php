<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Eloquent\User as EloquentUser;
use App\Repositories\UserRepository\UserEloquentRepository;
use App\Domain\Entities\User;
use App\Domain\Values\UserName;
use App\Domain\Values\UserId;

// Eloquentに依存する部分はLaravelのTestCaseに依存していいと思う
class UserEloquentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_insert()
    {
        $repository = new UserEloquentRepository();
        $user = new User(new UserName('tarou'), 'a@a.com');
        $repository->save($user);

        $this->assertDatabaseHas('users', ['name' =>  $user->name()->value()]);
    }

    public function test_update()
    {
        $savedUser = factory(EloquentUser::class)->create();
        $repository = new UserEloquentRepository();
        $user = new User(
            new UserName('renamed name'),
            'change@email.com',
            new UserId($savedUser->user_id)
        );
        $repository->save($user);

        $this->assertDatabaseHas('users', ['name' =>  $user->name()->value()]);
    }

    public function test_delete()
    {
        $savedUser = factory(EloquentUser::class)->create();
        $repository = new UserEloquentRepository();
        $user = new User(
            new UserName($savedUser->name),
            $savedUser->email,
            new UserId($savedUser->user_id)
        );
        $repository->delete($user);
        $this->assertDatabaseMissing('users', ['name' =>  $user->name()->value()]);
    }
}
