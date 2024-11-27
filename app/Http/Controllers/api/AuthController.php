<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();
            $errorCount = count($errors);

            $message = $errors[0];
            if ($errorCount > 1) {
                $message .= " (and " . ($errorCount - 1) . " more errors";
            } else {
                $message = $errors[0];
            }

            return response()->json([
                'message' => $message,
                'errors' => $errors
            ], 422);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Account has been created successfully'
        ]);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validate->fails()) {
            $errors = $validate->errors()->all();
            $errorCount = count($errors);

            $message = $errors[0];
            if ($errorCount > 1) {
                $message .= " (and " . ($errorCount - 1) . " more errors";
            } else {
                $message = $errors[0];
            }

            return response()->json([
                'message' => $message,
                'errors' => $errors
            ], 200);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong email or password.'
            ], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login Success.',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user->currentAccessToken()) {
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Logout Success.'
            ]);
        }

        return response()->json([
            'message' => 'Unauthenticated.'
        ]);
    }
}
