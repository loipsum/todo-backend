<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
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
            $request->user()->currentAccessToken()->delete();
            return response('Logout successful');
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
