<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    //

    public function index(): JsonResponse {
        return response()->json('Hello, World!', 200);
    }

    public function get($id): JsonResponse {

        $result = Community::query()->where('id', '=', $id)->get()->first();

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

     return response()->json('Community created successfully!', 201);
 }}
