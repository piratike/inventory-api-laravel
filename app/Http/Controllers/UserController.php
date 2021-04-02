<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\RequestController;

class UserController extends Controller
{
    function register(Request $request)
    {

        if(is_null($request->input('username')))
            return RequestController::returnFail('Signup error.', 'You have to give an username.', 500);

        if(is_null($request->input('email')))
            return RequestController::returnFail('Signup error.', 'You have to give an email.', 500);

        if(is_null($request->input('password')))
            return RequestController::returnFail('Signup error.', 'You have to give a password.', 500);

        $user = User::where('email', '=', $request->input('email'))->first();

        if(!is_null($user))
            return RequestController::returnSuccess($request->input('email'), 'Email already in use.');

        User::create([
            'name' => $request->input('username'),
            'email' =>  $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        return RequestController::returnSuccess($request->input('username'), 'Registered successfully.');

    }

    function login(Request $request)
    {

        if(is_null($request->input('email')))
            return RequestController::returnFail('Signup error.', 'You have to give an email.', 500);

        if(is_null($request->input('password')))
            return RequestController::returnFail('Signup error.', 'You have to give a password.', 500);

        $user = User::where('email', '=', $request->input('email'))->first();

        if(is_null($user) || !Hash::check($request->input('password'), $user->password))
            return RequestController::returnFail('Login error.', $request->input('email'), 500); //'The credentials do not match our records.'

        $token = $user->createToken('inventory-token')->plainTextToken;

        return RequestController::returnSuccess($token, 'Logged successfully.');

    }
}
