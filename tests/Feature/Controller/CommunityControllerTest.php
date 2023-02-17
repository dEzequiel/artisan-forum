<?php

namespace Controller;

use App\Models\Community;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommunityControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->getJson(route('get', [$community->id]));

        // Assert
        $response->assertOk();
        $response->assertJson([
            'id' => $community->id,
            'name' => $community->name,
            'description' => $community->description
        ]);

    }

    public function test_get_should_return_hello_world() {
        // Arrange
        $expectedMessage = 'Hello, World!';

        // Act
        $response = $this->getJson(route('index'));

        // Assert
        $response
            ->assertStatus(200)
            ->json($expectedMessage);
    }

    public function test_getAll_should_return_collection_of_communities_200OK(): void
    {
        // Arrange
        $totalCount = 5;
        $community = Community::factory($totalCount)->create();

        // Act
        $response = $this->getJson(route('getAll'));

        // Assert
        $response->assertOk();
        $response->assertJsonCount($totalCount);

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
            'id' => $community->id,
            'name' => $community->name,
            'description' => $community->description,
        ]);
    }

    public function test_should_delete_community_and_return_200OK_True(): void
    {
        // Arrange
        $community = Community::factory(3)->create();
        $idToDelete = $community[2]['id'];

        // Act
        $response = $this->deleteJson(route('delete', ['id' => $idToDelete]));
        $content = $response->getContent();

        $communities = Community::all();

        // Assert
        $response->assertOk();
        self::assertEquals(true, boolval($content));
        self::assertCount(2, $communities);
    }

    public function test_should_update_community_and_return_200OK(): void {

        // Arrange
        $community = Community::factory()->create();
        $idToUpdate = $community->id;

        // Act
        $response = $this->patchJson(route('update', [
            'id' => $idToUpdate,
            'name' => 'testeo',
            'description' => 'testeo'
        ]));

        // Assert
        $response->assertOk();
    }
}
