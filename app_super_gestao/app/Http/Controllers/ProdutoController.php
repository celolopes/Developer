<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Item;
use App\Models\Unidade;
use App\Models\ProdutoDetalhe;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Criar método index de produto
        $produtos = Item::with(['produtoDetalhe', 'fornecedor'])->paginate(10);

        return view('app.produto.index', ['produtos' => $produtos, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Criar a variável $unidades para receber os dados através do Model
        $unidades = Unidade::all();
        $fornecedores = Fornecedor::all();
        //Criar método create de produto
        return view('app.produto.create', ['unidades' => $unidades, 'fornecedores' => $fornecedores]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Criar os arrays de validações para Produto com $regras e $feedback
        $regras = [
            'nome' => 'required|min:3|max:40', //nome com no mínimo 3 caracteres e no máximo 40
            'descricao' => 'required|min:3|max:2000',
            'peso' => 'required|integer',
            'unidade_id' => 'exists:unidades,id',
            'fornecedor_id' => 'exists:fornecedores,id'
        ];

        $feedback = [
            'required' => 'O campo :attribute é obrigatório',
            'nome.min' => 'O campo nome deve conter no mínimo 3 caracteres',
            'nome.max' => 'O campo nome deve conter no máximo 40 caracteres',
            'descricao.min' => 'O campo nome deve conter no mínimo 3 caracteres',
            'descricao.max' => 'O campo nome deve conter no máximo 2000 caracteres',
            'peso.integer' => 'O campo peso deve ser um número interiro',
            'unidade_id.exists' => 'A unidade de medida informada não existe',
            'fornecedor_id.exists' => 'O fornecedor informado não existe'
        ];

        //validar os dados
        $request->validate($regras, $feedback);

        $produto = new Item();
        $produto->create($request->all());

        $msg = 'Produto cadastrado com sucesso!';

        return redirect()->route('produto.index', ['id' => $produto->id])->with('msg', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        //Criar método show
        return view('app.produto.show', ['produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        //Criar método edit
        $unidades = Unidade::all();
        $fornecedores = Fornecedor::all();

        return view('app.produto.edit', ['produto' => $produto, 'unidades' => $unidades, 'fornecedores' => $fornecedores]);
        //return view('app.produto.create', ['produto' => $produto, 'unidades' => $unidades]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $produto)
    {
        //Criar método update
        $regras = [
            'nome' => 'required|min:3|max:40', //nome com no mínimo 3 caracteres e no máximo 40
            'descricao' => 'required|min:3|max:2000',
            'peso' => 'required|integer',
            'unidade_id' => 'exists:unidades,id',
            'fornecedor_id' => 'exists:fornecedores,id'
        ];
        $feedback = [
            'required' => 'O campo :attribute é obrigatório',
            'nome.min' => 'O campo nome deve conter no mínimo 3 caracteres',
            'nome.max' => 'O campo nome deve conter no máximo 40 caracteres',
            'descricao.min' => 'O campo nome deve conter no mínimo 3 caracteres',
            'descricao.max' => 'O campo nome deve conter no máximo 2000 caracteres',
            'peso.integer' => 'O campo peso deve ser um número inteiro',
            'unidade_id.exists' => 'A unidade de medida informada não existe',
            'fornecedor_id.exists' => 'O fornecedor informado não existe'
        ];
        //validar os dados
        $request->validate($regras, $feedback);

        $produto->update($request->all());

        $msg = 'Produto atualizado com sucesso!';

        return redirect()->route('produto.show', ['produto' => $produto->id])->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        //Criar método destroy
        $produto->delete();

        $msg = 'Produto excluído com sucesso!';

        return redirect()->route('produto.index', ['id' => $produto->id])->with('msg', $msg);
    }
}
