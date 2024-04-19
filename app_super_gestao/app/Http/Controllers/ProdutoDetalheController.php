<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;
use App\Models\ProdutoDetalhe;
use App\Models\ItemDetalhe;

class ProdutoDetalheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unidades = Unidade::all();

        //Criar o método creater para produto_detalhe
        return view('app.produto_detalhe.create', ['unidades' => $unidades]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Criar o método creater para produto_detalhe
        ProdutoDetalhe::create($request->all());
        echo 'Produto cadastrado com sucesso.';
        //return redirect()->route('produto_detalhe.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produtoDetalhe = ItemDetalhe::with(['produto'])->find($id);
        //Criar método edit para produto_detalhe
        ProdutoDetalhe::find($produtoDetalhe);
        $unidades = Unidade::all();

        return view('app.produto_detalhe.edit', ['produto_detalhe' => $produtoDetalhe, 'unidades' => $unidades]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProdutoDetalhe $produtoDetalhe)
    {
        //Criar método update para produto_detalhe
        $produtoDetalhe->update($request->all());
        echo 'Produto atualizado com sucesso.';
        //return redirect()->route('produto_detalhe.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
