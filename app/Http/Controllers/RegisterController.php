<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'password' => 'required|min:5|max:255',
                    'email' => 'required|email|unique:users,email'
                ]
            );

            if ($validator->fails()) {
                return response(
                    ['message' => array_values($validator->getMessageBag()->getMessages())],
                    422
                );
            }

            $new_user = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password
                ]
            );
            return response(
                [
                    'new_user' => $new_user,
                    'message' => 'New user registered successfully'
                ],
                201
            );
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
