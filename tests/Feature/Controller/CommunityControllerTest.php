<?php

namespace Controller;

use App\Models\Community;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CommunityControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_should_return_community_by_id()
    {
        // Arrange
        $community = Community::factory()->create();

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
        );    }

    public function test_get_should_return_error_when_community_not_found()
    {
        // Arrange
        $idToFind = rand(2, 50);

        // Act
        $response = $this->getJson(route('api.v1.community.get', [$idToFind]));

        // Assert
        $response->assertOk();
        $response->assertJson([
            'code' => 404,
            'message' => 'Community not found',
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
    }

    public function test_should_delete_community_and_return_200OK_True(): void
    {
        // Arrange
        $community = Community::factory(3)->create();
        $idToDelete = $community[2]['id'];

        // Act
        $response = $this->deleteJson(route('api.v1.community.delete', ['id' => $idToDelete]));
        $json_decode = json_decode($response->getContent(), true);

        $communities = Community::all();

        // Assert
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'isDeleted' => $json_decode['data']['isDeleted']
                ],
                'links' => [
                    'self' => route('api.v1.community.delete')
                ]
            ]);
        self::assertCount(2, $communities);
    }

//    public function test_should_update_community_and_return_200OK(): void {
//
//        // Arrange
//        $community = Community::factory()->create();
//        $idToUpdate = $community->id;
//
//        // Act
//        $response = $this->patchJson(route('update', [
//            'id' => $idToUpdate,
//            'name' => 'testeo',
//            'description' => 'testeo'
//        ]));
//
//        // Assert
//        $response->assertOk();
//    }
}
