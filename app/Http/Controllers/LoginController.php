<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email', Rule::exists('users', 'email')],
                'password' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response(array_values($validator->getMessageBag()->getMessages()), 422);
        }
        try {
            $user = User::whereEmail($request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw new Exception('Email/password is incorrect', 422);
            }

            return ['token' => $user->createToken('auth-token')->plainTextToken];
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
