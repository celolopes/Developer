<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContato;
use \App\Models\MotivoContato;

class ContatoController extends Controller
{
    public function contato(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        /* $contato = new SiteContato;
        $contato->nome = $request->input('nome');
        $contato->telefone = $request->input('telefone');
        $contato->email = $request->input('email');
        $contato->motivo_contato = $request->input('motivo_contato');
        $contato->mensagem = $request->input('mensagem');
        $contato->save(); */

        //Crie o objeto contato através do método fill recebendo a request
        /* $contato = new SiteContato();
        $contato->create($request->all()); */
        $motivo_contatos = MotivoContato::all();

        //Retorna a view contato com o objeto contato
        return view('site.contato', ['titulo' => 'Contato', 'motivo_contatos' => $motivo_contatos]);
    }

    public function salvar(Request $request)
    {
        //Realizar a validação dos dados do formulário recebidos no request
        $request->validate([
            'nome' => 'required|min:3|max:40|unique:site_contatos', //nome com no mínimo 3 caracteres e no máximo 40
            'telefone' => 'required',
            'email' => 'email',
            'motivo_contatos_id' => 'required',
            'mensagem' => 'required|max:2000'
        ], [
            //Crie as validações dos campos de dados
            'required' => 'O :attribute é obrigatório',
            'nome.min' => 'O nome deve conter no mínimo 3 caracteres',
            'nome.max' => 'O nome deve conter no máximo 40 caracteres',
            'nome.unique' => 'O nome já existe',
            'email.email' => 'O e-mail é inválido',
            'motivo_contatos_id.required' => 'O motivo é obrigatório',
            'mensagem.required' => 'A mensagem é obrigatória',
            'mensagem.max' => 'A mensagem deve conter no máximo 2000 caracteres'
        ]);
        SiteContato::create($request->all());
        //return para a página princial em site.principal
        return redirect()->route('site.confirmado');
    }
}
