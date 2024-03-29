<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //Criar uma função index com um retorno de view
    public function index(Request $request)
    {
        $erro = $request->get('erro');

        //Condição da variável $erro se for igual a 1 informar que Login e Senha são inválidos
        if ($erro == 1) {
            $erro = 'Usuário e/ou senha não existe!!';
        }
        if ($erro == 2) {
            $erro = 'Necessário realiar login para ter acesso a página!!';
        }

        return view('site.login', ['titulo' => 'Login', 'erro' => $erro]);
    }

    //Criar uma função autenticar com um retorno de view
    public function autenticar(Request $request)
    {
        $regras = [
            'usuario' => 'required|email',
            'password' => 'required'
        ];

        //definir as mensagens de feedback de validação
        $feedback = [
            'usuario.required' => 'O campo usuário é obrigatório',
            'usuario.email' => 'O campo usuário deve ser um e-mail válido',
            'password.required' => 'O campo senha é obrigatório'
        ];

        //validar os dados
        $request->validate($regras, $feedback);

        //recuperar através de request as veriáveis $email e $password do formulário
        $email = $request->get('usuario');
        $password = $request->get('password');

        //Iniciar o Model User
        $users = new \App\Models\User;

        //Verificar se o usuário existe
        $user = $users->where('email', $email)->first();

        //Verificar se a senha é igual a senha do usuário
        if ($user && $user->password == $password) {
            session_start();
            $_SESSION['email'] = $user->email;
            $_SESSION['nome'] = $user->name;
            //redirecionar para a página principal
            return redirect()->route('app.home');
        } else {
            //redirecionar para a página de login
            return redirect()->route('site.login', ['erro' => 1])->withErrors('Usuário ou senha inválidos');
        }
    }

    //Criar uma função para logout
    public function sair()
    {
        session_destroy();
        return redirect()->route('site.index');
    }
}
