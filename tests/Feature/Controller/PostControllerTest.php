<?php

namespace Controller;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function test_post_form_is_displayed_if_user_authenticated(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
                         ->json('GET', '/post');

        // Assert
        $this->assertAuthenticatedAs($user, $guard = null);
        $response->assertOk();
        $response->assertViewIs('post.form');
    }

    public function test_post_form_is_NOT_displayed_if_user_is_NOT_authenticated(): void
    {
        // Act & assert
        $this
            ->json('GET', '/post')
            ->assertStatus(401)
            ->assertExactJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function test_should_add_post_and_return_201Created(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->postJson('/post', [
                'title' => 'Test',
                'body' => 'Test',
                'extract' => 'Test',
                'visibility' => true
            ]);

        // Assert
        $this->assertAuthenticatedAs($user, $guard = null);
        $response
            ->assertStatus(201)
            ->assertExactJson(['Post created successfully!']);
    }

    public function test_should_NOT_add_post_and_return_422UnprocessableEntity(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)
            ->postJson('/post', [
            ]);

        // Assert
        $this->assertAuthenticatedAs($user, $guard = null);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['title', 'body', 'extract']]);
    }

/*    public function test_should_remove_post_and_return_200OK(): void
    {
        // Arrange
        $user = User::factory()->create();
        $post = new Post;
        $post->title = 'Test';
        $post->extract = 'Test';
        $post->content = 'Test';
        $post->user_id = $user;

        // Act
        $response = $this->actingAs($user)
            ->deleteJson('/post', [
                'id' => $post->id
            ]);

        // Assert
        $response->assertStatus(200);
    }*/



}
