<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase; // garante que o banco de teste é limpo a cada teste

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // Instancia a service com o repository real
        $this->userService = new UserService(new UserRepository());
    }

    /** @test */
    public function it_returns_null_if_user_does_not_exist()
    {
        $user = $this->userService->getById(999);
        $this->assertNull($user);
    }

    /** @test */
    public function it_returns_user_if_exists()
    {
        $createdUser = User::factory()->create();

        $fetchedUser = $this->userService->getById($createdUser->id);

        $this->assertNotNull($fetchedUser);
        $this->assertEquals($createdUser->id, $fetchedUser->id);
        $this->assertEquals($createdUser->email, $fetchedUser->email);
    }
}
