<?php

namespace App\Http\Controllers\RestApi\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Login function for REST API
     *
     * @param  mixed $request
     * @return Response
     */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email|max:80',
            'password' => ['required', 'string', Password::defaults()],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials',
            ], 401);
        }

        $api_token = $user->createToken('api_token')->plainTextToken;

        $response = [
            'message' => 'Welcome in PrestaCure API',
            'user' => $user,
            'token' => $api_token,
        ];

        return response($response, 201);
    }

    /**
     * Logout function for REST API
     *
     * @param  mixed $request
     * @return Response
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response([
            'message' => 'Logout succesfull',
        ], 200);
    }
}
