<?php

namespace Controller;

use Tests\TestCase;

class CommunityControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_should_return_community_by_id()
    {
        // Arrange
        $communityId = 1;

        // Act
        $response = $this->getJson('/api/community', ['id' => strval($communityId)]);

        // Assert
        $response
            ->assertStatus(200);
    }

    public function test_get_should_return_hello_world() {
        // Arrange
        $expectedMessage = 'Hello, World!';

        // Act
        $response = $this->getJson('/api/community');

        // Assert
        $response
            ->assertStatus(200)
            ->json($expectedMessage);
    }

    public function test_should_add_community_and_return_201Created(): void
    {
        // Arrange

        // Act
        $response = $this->postJson('/api/community', [
                'name' => 'Test',
                'description' => 'Test',
            ]);

        // Assert
        $response
            ->assertStatus(201)
            ->assertExactJson(['Community created successfully!']);
    }
}
