<?php

namespace App\Http\Controllers\API;

use App\ApiRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthSignInRequest;
use App\Http\Requests\API\AuthSignUpRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['signin', 'signup']]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function signin(AuthSignInRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function signup(AuthSignUpRequest $request)
    {
        // Validasi data
        $data = $request->validated();

        // Buat user baru
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        // Buat user profile baru
        $user->profile()->create([
            'registration_number' => $data['registration_number'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address']
        ]);

        $studentRole = ApiRole::findByName('student');
        $user->assignRole($studentRole);

        // Return success
        return response()->json(['message' => 'Successfully registered']);
    }

    public function signout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
