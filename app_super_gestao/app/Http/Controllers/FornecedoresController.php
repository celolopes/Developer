<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    public function index()
    {
        return view('app.fornecedor.index');
    }

    //Criar método listar chamando a view app.fornecedor.listar
    public function listar(Request $request)
    {
        $nome = $request->nome;
        $site = $request->site;
        $uf = $request->uf;
        $email = $request->email;

        return view('app.fornecedor.listar', compact('nome', 'site', 'uf', 'email'));
    }

    //Método adicionar que irá efetuar a criação do fornecedor através do create
    public function adicionar()
    {
        return view('app.fornecedor.adicionar');
    }
}
