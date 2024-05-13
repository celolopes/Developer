<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|string'
            ],
            [
                'email.required' => 'O campo email é obrigatório',
                'email.email' => 'O campo email deve ser um email válido',
                'password.required' => 'O campo senha é obrigatório',
                'password.string' => 'O campo senha deve ser uma string',
            ]
        );

        $token = auth('api')->attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$token) {
            return response()->json([
                'error' => 'Email ou senha inválidos'
            ], 403);
        } else {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer'
            ]);
        }
    }

    public function logout(Request $request)
    {
        auth('api')->logout();
        return response()->json([
            'message' => 'Logout efetuado com sucesso'
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function refresh()
    {
        $token = auth('api')->refresh();
        return response()->json(['access_token' => $token]);
    }
}
