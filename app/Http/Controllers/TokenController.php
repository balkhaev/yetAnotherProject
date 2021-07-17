<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->tokens->all();
    }

    public function delete(Request $request, $id)
    {
        return $request->user()->tokens->where('id', $id)->delete();
    }

    public function create(Request $request)
    {
        $token = $request->user()->createToken($request->token_name);

        return ['token' => $token->plainTextToken];
    }
}
