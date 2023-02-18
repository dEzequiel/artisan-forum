<?php

namespace Controller;

use App\Models\User;
use Tests\TestCase;

class TokenAdminControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_should_generate_api_token_for_a_given_user()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->postJson(route('generate'), ['user_id' => $user->id]);

        // Assert
        $response->assertOk();
        $response->assertSee('bearer_token');
    }
}
