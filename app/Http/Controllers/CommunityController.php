<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityCollectionResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\ErrorResource;
use App\Models\Community;
use Exception;
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

     public function delete(Request $request): Response
     {

        $communityId = $request->input('id');

         try {
             Community::query()->where('id', '=', $communityId)->delete();
         } catch (Exception $e) {
             echo 'Caught exception: ',  $e->getMessage(), "\n";
         }

         return response(true, 200);
     }

     public function update(Request $request): JsonResponse {
        $communityId = $request->input('id');

        try {
            Community::query()->where('id', '=', $communityId)->update([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        $community = Community::query()->where('id', '=', $communityId)->get();

         return response()->json($community, 200);

     }
}
