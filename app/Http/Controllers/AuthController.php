<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


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
                Response::HTTP_UNAUTHORIZED
            );
        }

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
            $token = $user->createToken('AuthToken')->plainTextToken;

            $cookie = cookie('jwt', $token, 60 * 24);

            return response()->json(
                [
                    'access_token' => $token,
                    'type_token' => 'Bearer',
                ],
                Response::HTTP_OK

            )->withCookie($cookie);
        };
    }

    // GET USER AFTER LOGIN
    public function user()
    {
        return Auth::user();
    }

    // REGISTER
    public function register(Request $request)
    {
        $message = [
            'email.email' => 'Error Email',
        ];
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required',
        ], $message);

        if ($validate->fails()) {
            return response()->json(
                [
                    'message' => $validate->errors(),
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

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
    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $cookie = Cookie::forget('jwt');

        return response()->json(
            [
                'message' => 'Logout Success',
            ],
            Response::HTTP_OK
        )->withCookie($cookie);
    }

    // CHANGE PASSWORD
    public function updatePassword(Request $request)
    {
        // Validation

        $request->validate([
            'old_password' => ['required', 'current_password:sanctum'],
            'new_password' => 'required|confirmed',
        ]);

        // Update the new password

        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(
            [
                'message' => 'Update Success',
            ],
            Response::HTTP_OK
        );
    }
}
