<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {

        // $message = [
        //     'email.email' => 'Error Email',
        // ];

        $validate = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required',
        ]);

        // CHECK VALIDATE LOGIN FIELD

        if ($validate->fails()) {
            return response()->json(
                [
                    'message' => $validate->errors()->first(),
                    'errors' => $validate->errors(),
                ],
                Response::HTTP_UNAUTHORIZED
            );
        } else {

            // CHECK LOGIN AFTER ENTER FULL FIELD

            $user = User::where(['email' => $request->email])->first();
            if (!$user) {
                return response()->json(
                    [
                        'message' => 'User not exist!',
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            } elseif (!Hash::check($request->password, $user->password, [])) {
                return response()->json(
                    [
                        'message' => 'Wrong password!',
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            } else {
                // CREATE TOKEN
                $token = $user->createToken('AuthToken')->plainTextToken;

                return response()->json(
                    [
                        'access_token' => $token,
                        'type_token' => 'Bearer',
                    ],
                    Response::HTTP_OK

                );
            };
        }
    }

    // GET USER AFTER LOGIN
    public function user()
    {
        return Auth::user();
    }

    // REGISTER
    public function register(Request $request)
    {
        // $message = [
        //     'email.email' => 'Error Email',
        // ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|confirmed',
        ]);

        // CHECK VALIDATE
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors(),
                ],
                Response::HTTP_BAD_REQUEST
            );
        } else {
            // CREATE USER
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(
                [
                    'message' => "Created Success"
                ],
                Response::HTTP_CREATED
            );
        }
    }
    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'message' => 'Logout Success',
            ],
            Response::HTTP_OK
        );
    }

    // REFRESH TOKENS
    public function refreshToken(Request $request)
    {
        $accessToken = $request->user()->currentAccessToken();
        if (
            !$accessToken || ($this->expiration && $accessToken->created_at->lte(now()->subMinutes($this->expiration))) || !$this->hasValidProvider($accessToken->tokenable)
        ) {
            return;
        }

        $request->user()->tokens()->delete();

        $newToken = $request->user->createToken('AuthToken')->plainTextToken;

        return response()->json([
            'access_token' => $newToken
        ]);
    }

    // CHANGE PASSWORD
    public function updatePassword(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'current_password:sanctum'],
            'new_password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } else {
            Auth::user()->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json(
                [
                    'message' => 'Updated password successfully!',
                ],
                Response::HTTP_OK
            );
        }

        // $request->validate([
        //     'old_password' => ['required', 'current_password:sanctum'],
        //     'new_password' => 'required|confirmed',
        // ]);

        // Update the new password
    }
}
