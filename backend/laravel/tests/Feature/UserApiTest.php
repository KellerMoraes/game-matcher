<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Urutu',
            'email' => 'urutu@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id', 'name', 'email', 'created_at', 'updated_at'
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'urutu@example.com'
        ]);
    }

    /** @test */
    public function it_fails_if_data_is_invalid()
    {
        $response = $this->postJson('/api/users', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function it_can_fetch_a_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'name' => $user->name,
                     'email' => $user->email,
                 ]);
    }
}
