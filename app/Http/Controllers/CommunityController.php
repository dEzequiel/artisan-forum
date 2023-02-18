<?php

namespace App\Http\Controllers;

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
            $error = array(
                'code'      => 404,
                'message'   => 'Community with id ' . $id . ' not found!',
                'data'      => null
            );

            return response()->json($error);
        }

        return response()->json($result, 200);
    }

    public function getAll(): JsonResponse {
        $result = Community::all();

        return response()->json($result, 200);
    }

    public function store(Request $request): JsonResponse
     {

         $community = new Community;
         $community->name = $request->input('name');
         $community->description = $request->input('description');

         try {
             $community->save();
         } catch (Exception $e) {
             echo 'Caught exception: ',  $e->getMessage(), "\n";
         }

         return response()->json($community, 201);
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
