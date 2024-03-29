<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    //Criar método index com return para view app.produto
    public function index()
    {
        return view('app.produto');
    }
}
