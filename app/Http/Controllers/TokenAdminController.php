<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class TokenAdminController extends Controller
{

    use HasApiTokens;

    public function generateToken(Request $request): JsonResponse {
        $user = User::find($request->user_id);

        if(is_null($user)) {
            $error = array(
                'code'      => 404,
                'message'   => 'Community with id ' . $request->user_id . ' not found!',
                'data'      => null
            );

            return response()->json($error);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['user' => $user, 'bearer_token' => $token]);

    }
}
