<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::all();
        return $accounts;
    }
    //DELETE ACCOUNT
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Account deleted successfully!'
        ], Response::HTTP_OK);
    }
}
