<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityCollectionResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\CommunityDeleteResponseResource;
use App\Models\Community;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CommunityController extends Controller
{
    //

    public function index(): JsonResponse {
        return response()->json('Hello, World!', 200);
    }

    public function get($id): JsonResponse {

        $result = Community::query()->where('id', '=', $id)->get()->first();

        if(is_null($result)) {
            return (new ErrorResource(404, 'Community not found'))->response();
        }

        return (new CommunityResource($result))->response();
    }

    public function getAll(): JsonResponse {
        $result = Community::all();

        return ( new CommunityCollectionResource($result))->response();
    }

    public function store(Request $request): JsonResponse
     {

         $community = new Community;

         try {
             $community->name = $request->input('name');
             $community->description = $request->input('description');
             $community->save();
         } catch (Exception $e) {
             echo 'Caught exception: ',  $e->getMessage(), "\n";
         }

         return (new CommunityResource($community))->response();
     }

     public function delete(Request $request): JsonResponse
     {

        $communityId = $request->input('id');

         try {
             $isDeleted = Community::query()->where('id', '=', $communityId)->delete();
         } catch (Exception $e) {
             echo 'Caught exception: ',  $e->getMessage(), "\n";
         }

         return (new CommunityDeleteResponseResource(boolval($isDeleted)))->response();
     }

     public function update(Request $request, $id): JsonResponse {
        $community = $this->getCommunityIfExists($id);

        try {
            Community::query()->where('id', '=', $id)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }


        $updatedCommunity = $community->refresh();
         return (new CommunityResource($updatedCommunity))->response();
     }

     private function getCommunityIfExists($id): Community {
        $community = Community::query()->where('id', '=', $id)->get()->first();

        if(is_null($community)) {
            throw new ModelNotFoundException('COMMUNITY NOT FOUND');
        }

        return $community;
     }
}
