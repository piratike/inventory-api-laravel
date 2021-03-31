<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\RequestController;

class UserController extends Controller
{
    function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password))
            return RequestController::returnFail('Login error.', 'The credentials do not match our records.', 501);

        $token = $user->createToken('inventory-token')->plainTextToken;

        return RequestController::returnSuccess($token, 'Logged successfully.');

    }
}
