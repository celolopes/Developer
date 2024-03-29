<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SobreNosController extends Controller
{
    //Método construtor para chamar o middlewareRoute 'log.acesso'
    public function __construct()
    {
        $this->middleware('log.acesso');
    }
    public function sobreNos()
    {
        return view('site.sobre-nos');
    }
}
