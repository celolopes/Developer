<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedoresController extends Controller
{
    public function index()
    {
        return view('app.fornecedor.index');
    }

    //Criar método listar chamando a view app.fornecedor.listar
    public function listar(Request $request)
    {

        $fornecedores = Fornecedor::where('nome', 'like', '%' . $request->input('nome') . '%')
            ->where('site', 'like', '%' . $request->input('site') . '%')
            ->where('uf', 'like', '%' . $request->input('uf') . '%')
            ->where('email', 'like', '%' . $request->input('email') . '%')
            ->paginate(2);

        return view('app.fornecedor.listar', ['fornecedores' => $fornecedores, 'request' => $request->all()]);
    }

    //Método adicionar que irá efetuar a criação do fornecedor através do create
    public function adicionar(Request $request)
    {
        $msg = '';

        //Condição de inserção do fornecedor
        if ($request->input('_token') != '' && $request->input('id') == '') {
            $regras = [
                'nome' => 'required|min:3|max:40', //nome com no mínimo 3 caracteres e no máximo 40
                'site' => 'required',
                'uf' => 'required|min:2|max:2',
                'email' => 'email'
            ];

            $feedback = [
                'required' => 'O campo :attribute é obrigatório',
                'nome.min' => 'O campo nome deve conter no mínimo 3 caracteres',
                'nome.max' => 'O campo nome deve conter no máximo 40 caracteres',
                'uf.min' => 'O campo UF deve conter no mínimo 2 caracteres',
                'uf.max' => 'O campo UF deve conter no máximo 2 caracteres',
                'email.email' => 'O e-mail é inválido'
            ];

            $request->validate($regras, $feedback);

            $fornecedor = new Fornecedor();
            $fornecedor->create($request->all());

            $msg = 'Fornecedor cadastrado com sucesso!';
        }
        //Condição de edição do Fornecedor
        if ($request->input('_token') != '' && $request->input('id') != '') {
            $regras = [
                'nome' => 'required|min:3|max:40', //nome com no mínimo 3 caracteres e no máximo 40
                'site' => 'required',
                'uf' => 'required|min:2|max:2',
                'email' => 'email'
            ];

            $feedback = [
                'required' => 'O campo :attribute é obrigatório',
                'nome.min' => 'O campo nome deve conter no mínimo 3 caracteres',
                'nome.max' => 'O campo nome deve conter no máximo 40 caracteres',
                'uf.min' => 'O campo UF deve conter no mínimo 2 caracteres',
                'uf.max' => 'O campo UF deve conter no máximo 2 caracteres',
                'email.email' => 'O e-mail é inválido'
            ];

            $request->validate($regras, $feedback);

            $fornecedor = Fornecedor::find($request->input('id'));
            $update = $fornecedor->update($request->all());

            if ($update) {
                $msg = 'Fornecedor editado com sucesso!';
            } else {
                $msg = 'Erro ao editar fornecedor!';
            }

            return redirect()->route('app.fornecedor.editar', ['id' => $request->input('id'), 'msg' => $msg]);
        }

        //Realizar a validação dos dados do formulário recebidos no request
        return view('app.fornecedor.adicionar', ['msg' => $msg]);
    }

    //Criar método editar para edição dos dados do formulário de Fornecedor
    public function editar($id, $msg = '')
    {
        $fornecedor = Fornecedor::find($id);

        return view('app.fornecedor.adicionar', ['fornecedor' => $fornecedor, 'msg' => $msg]);
    }

    //Criar método excluir para exclusão dos dados do formulário de Fornecedor
    public function excluir($id)
    {
        $fornecedor = Fornecedor::find($id);
        $fornecedor->delete();
        return redirect()->route('app.fornecedor');
    }
}
