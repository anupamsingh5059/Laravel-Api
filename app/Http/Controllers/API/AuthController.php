<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

                public function register(Request $request)
            {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            ]);


            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            }


            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            ]);


            $token = $user->createToken('api_token')->plainTextToken;


            return response()->json([ 'user' => $user, 'token' => $token ], 201);
            }


            public function login(Request $request)
            {
            $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            ]);


            if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            }


            $user = User::where('email', $request->email)->first();


            if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
            }


            // delete old tokens (optional)
            $user->tokens()->delete();


            $token = $user->createToken('api_token')->plainTextToken;


            return response()->json([ 'user' => $user, 'token' => $token ]);
            }


            public function logout(Request $request)
            {
            // Revoke current token
            $request->user()->currentAccessToken()->delete();


            return response()->json(['message' => 'Logged out']);
            }


            public function me(Request $request)
            {
            return response()->json($request->user());
            }
}
