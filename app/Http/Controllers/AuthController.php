<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        $credentials = $r->only('email','password');
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error'=>'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function me()     { return response()->json(auth('api')->user()); }
    public function logout() { auth('api')->logout(); return response()->json(['logout'=>true]); }
    public function refresh(){ return $this->respondWithToken(auth('api')->refresh()); }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token'=> $token,
            'token_type'  => 'bearer',
            'expires_in'  => auth('api')->factory()->getTTL() * 60,
            'user'        => auth('api')->user(),
        ]);
    }
}
