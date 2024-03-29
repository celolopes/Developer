<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //Criar método index pegando a view
    public function index()
    {
        return view('app.cliente');
    }
}
