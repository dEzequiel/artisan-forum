<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class TokenAdminController extends Controller
{

    use HasApiTokens;

    public function generateToken(Request $request): JsonResponse
    {
        $user = User::find($request->user_id);

        if (is_null($user)) {
            $error = array(
                'code' => 404,
                'message' => 'User with id ' . $request->user_id . ' not found!',
                'data' => null
            );

            return response()->json($error);
        }

        if ($this->checkIfTokenAlreadyGenerated($user->id)) {
            $token = $user->createToken('api_token')->plainTextToken;
        } else {
            $error = array('message' => 'Token for user with id ' . $request->user_id . ' already generated.');
            return response()->json($error);
        }

        return response()->json(['user' => $user, 'bearer_token' => $token]);
    }

    private function checkIfTokenAlreadyGenerated($user_id) {
        $token = DB::table('personal_access_tokens')->where(['tokenable_id' => $user_id])->exists();

        if(!$token) {
            return true;
        }

        return false;

    }
}
