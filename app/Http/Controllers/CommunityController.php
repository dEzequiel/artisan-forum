<?php

namespace App\Http\Controllers;

use App\Http\HttpCode;
use App\Http\Resources\CommunityCollectionResource;
use App\Http\Resources\CommunityResource;
use App\Http\Resources\ErrorResponseResource;
use App\Models\Community;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class CommunityController extends Controller
{

    public function index(): JsonResponse {
        $result = Community::all();

        return (new CommunityCollectionResource($result))->response();
    }

    public function show($id): JsonResponse {
        $result = $this->getCommunityIfExists($id);

        if (!($result instanceof Community)) {
            return $result;
        }

        return (new CommunityResource($result))->response();
    }

    public function store(Request $request): JsonResponse {
         $community = new Community;

         try {
             $community->name = $request->input('name');
             $community->description = $request->input('description');
             $community->save();
         } catch (Exception $e) {
             echo 'Caught exception: ',  $e->getMessage(), "\n";
         }

         return (new CommunityResource($community))->response()->setStatusCode(HttpCode::CREATED);
     }
     public function destroy($id): JsonResponse {
        $result = $this->getCommunityIfExists($id);

         if (!($result instanceof Community)) {
             return $result;
         }

         try {
             $result->delete();
         } catch (Exception $e) {
             echo 'Caught exception: ',  $e->getMessage(), "\n";
         }

         return (new CommunityResource($result))->response();
     }


     public function update(Request $request, $id): JsonResponse {
         $result = $this->getCommunityIfExists($id);

         if (!($result instanceof Community)) {
             return $result;
         }

         try {
             $result->update([
                 'name' => $request->input('name'),
                 'description' => $request->input('description')
             ]);
             $result->refresh();
         } catch (Exception $e) {
             echo 'Caught exception: ', $e->getMessage(), "\n";
         }

         return (new CommunityResource($result))->response();
     }

     private function getCommunityIfExists($id): JsonResponse | Community {
        $community = Community::query()->where('id', '=', $id)->get()->first();

        if(is_null($community)) {
            return (new ErrorResponseResource(HttpCode::NOT_FOUND, 'COMMUNITY NOT FOUND'))->response()->setStatusCode(HttpCode::NOT_FOUND);
        }

        return $community;
     }
}
