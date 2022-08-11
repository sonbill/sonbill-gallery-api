<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {

        // CHECK VALIDATE LOGIN FIELD
        $message = [
            'email.email' => 'Error Email',
        ];

        $validate = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required',
        ], $message);

        if ($validate->fails()) {
            return response()->json(
                [
                    'message' => $validate->errors(),
                ],
                404
            );
        }


        // CHECK LOGIN AFTER ENTER FULL FIELD
        $user = User::where(['email' => $request->email])->first();

        if (!$user) {
            return response()->json(
                [
                    'message' => 'User not exist!',
                ],
                404
            );
        } elseif (!Hash::check($request->password, $user->password, [])) {
            return response()->json(
                [
                    'message' => 'Wrong password!',
                ],
                404
            );
        } else {
            $token = $user->createToken('AuthToken')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'type_token' => 'Bearer',
            ]);
        }
    }

    // GET USER AFTER LOGIN
    public function user(Request $request)
    {
        return $request->user();
    }

    // REGISTER
    public function register(Request $request)
    {
        $message = [
            'email.email' => 'Error Email',
        ];
        $validate = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required',
        ], $message);

        if ($validate->fails()) {
            return response()->json(
                [
                    'message' => $validate->errors(),
                ],
                404
            );
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            [
                'message' => "Created Success"
            ],
            200
        );
    }
    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'message' => 'Logout',
            ],
            200
        );
        // return 'Logout!';
    }
}
