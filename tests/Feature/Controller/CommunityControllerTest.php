<?php

namespace Controller;

use App\Models\Community;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommunityControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_should_return_hello_world(): void {
        // Arrange
        $expectedMessage = 'Hello, World!';
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->getJson(route('index'));

        // Assert
        $response->assertOk();
    }

    public function test_get_should_return_community_by_id(): void
    {
        // Arrange
        $community = Community::factory()->create();
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->getJson(route('api.v1.community.get', [$community->id]));

        // Assert
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'type' => 'community',
                'id' => $community->id,
                'attributes' => [
                    'community_id' => $community->id,
                    'name' => $community->name,
                    'description' => $community->description
                ],
                'links' => [
                    'self' => route('api.v1.community.get', $community->getRouteKey())
                ]
            ]
        ]);

        $response->assertHeader(
            'Content-Type', 'application/vnd.api+json'
        );
    }

    public function test_get_should_not_get_community_by_id()
    {
        // Arrange
        $nonexistentId = 32;
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->getJson(route('api.v1.community.get', [$nonexistentId]));

        // Assert
        $response->assertNotFound();
        $response->assertJson([
            'code' => 404,
            'message' => 'COMMUNITY NOT FOUND',
            'data' => null
        ]);

        $response->assertHeader(
            'Content-Type', 'application/json'
        );
    }

    public function test_getAll_should_return_collection_of_communities_200OK(): void
    {
        // Arrange
        $totalCount = 2;
        $community = Community::factory($totalCount)->create();
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->getJson(route('api.v1.community.getAll'));
        $json_decode = json_decode($response->getContent(), true);

        // Assert
        $response->assertOk();
        $this->assertCount($totalCount, $json_decode['data']);
        $response->assertJson([
            'data' => [
                [
                    'id' => $community[0]->id,
                    'name' => $community[0]->name,
                    'description' => $community[0]->description
                ],
                [
                    'id' => $community[1]->id,
                    'name' => $community[1]->name,
                    'description' => $community[1]->description
                ]
            ],
            'links' => [
                'self' => route('api.v1.community.getAll')
            ]
        ]);

        $response->assertHeader(
            'Content-Type', 'application/vnd.api+json'
        );
    }

    public function test_getAll_should_return_empty_collection_of_communities_200OK(): void
    {
        // Arrange
        $totalCount = 0;
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->getJson(route('api.v1.community.getAll'));
        $json_decode = json_decode($response->getContent(), true);

        // Assert
        $response->assertOk();
        $this->assertCount($totalCount, $json_decode['data']);
        $response->assertJson([
            'data' => [],
            'links' => [
                'self' => route('api.v1.community.getAll')
            ]
        ]);

        $response->assertHeader(
            'Content-Type', 'application/vnd.api+json'
        );
    }

    public function test_should_add_community_and_return_201Created(): void
    {
        // Arrange
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->postJson(route('add', [
                'name' => 'Test',
                'description' => 'Test',
            ]));

        $community = Community::query()->first();

        // Assert
       $response->assertCreated();
        $response->assertJson([
            'data' => [
                'type' => 'community',
                'id' => $community->id,
                'attributes' => [
                    'community_id' => $community->id,
                    'name' => $community->name,
                    'description' => $community->description
                ],
                'links' => [
                    'self' => route('api.v1.community.get', $community->getRouteKey())
                ]
            ]
        ]);
        $response->assertHeader(
            'Content-Type', 'application/vnd.api+json'
        );
    }

    public function test_should_delete_community_and_return_200OK_True(): void
    {
        // Arrange
        $community = Community::factory(3)->create();
        $idToDelete = $community[2]['id'];
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->deleteJson(route('api.v1.community.delete', ['id' => $idToDelete]));
        $json_decode = json_decode($response->getContent(), true);

        $communities = Community::all();

        // Assert
        self::assertCount(2, $communities);
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'isDeleted' => $json_decode['data']['isDeleted']
                ],
                'links' => [
                    'self' => route('api.v1.community.delete')
                ]
            ]);

        $response->assertHeader(
            'Content-Type', 'application/vnd.api+json'
        );
    }

    public function test_should_not_delete_community_when_not_found(): void
    {
        // Arrange
        $nonexistentId = 32;
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->deleteJson(route('api.v1.community.delete', ['id' => $nonexistentId]));

        // Assert
        $response->assertNotFound();
        $response->assertJson([
            'code' => 404,
            'message' => 'COMMUNITY NOT FOUND',
            'data' => null
        ]);

        $response->assertHeader(
            'Content-Type', 'application/json'
        );
    }

    public function test_should_update_community_and_return_200OK(): void {

        // Arrange
        $community = Community::factory()->create();
        $idToUpdate = $community->id;
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->patchJson(route('api.v1.community.update', [
            'id' => $idToUpdate,
            'name' => 'Test',
            'description' => 'Test'
        ]));

        // Assert
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'type' => 'community',
                'id' => $idToUpdate,
                'attributes' => [
                    'community_id' => $community->id,
                    'name' => 'Test',
                    'description' => 'Test'
                ],
                'links' => [
                    'self' => route('api.v1.community.update', $community->getRouteKey())
                ]
            ]
        ]);

        $response->assertHeader(
            'Content-Type', 'application/vnd.api+json'
        );
    }

    public function test_should_not_update_community_when_not_found(): void
    {
        // Arrange
        $nonexistentId = 32;
        Sanctum::actingAs(User::factory()->create());

        // Act
        $response = $this->patchJson(route('api.v1.community.update', [
            'id' => $nonexistentId,
            'name' => 'Test',
            'description' => 'Test'
        ]));

        // Assert
        $response->assertNotFound();
        $response->assertJson([
            'code' => 404,
            'message' => 'COMMUNITY NOT FOUND',
            'data' => null
        ]);

        $response->assertHeader(
            'Content-Type', 'application/json'
        );
    }
}
