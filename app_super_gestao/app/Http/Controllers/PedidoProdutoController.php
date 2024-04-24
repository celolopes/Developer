<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\PedidoProduto;

class PedidoProdutoController extends Controller
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
    public function create(Pedido $pedido)
    {
        //
        $produtos = Produto::all();
        $pedido->produtos; //eager loading
        return view('app.pedido_produto.create', ['pedido' => $pedido, 'produtos' => $produtos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pedido $pedido)
    {
        //Criar a função store de Pedido Produto
        $request->validate([
            'produto_id' => 'exists:produtos,id',
            'quantidade' => 'required|numeric|min:1',
        ], [
            'produto_id.exists' => 'O Produto informado não existe',
            'quantidade.required' => 'O campo quantidade deve ser preenchido',
            'quantidade.numeric' => 'O campo quantidade deve ser um número',
            'quantidade.min' => 'O campo quantidade deve ser maior que 0',
        ]);

        /* $pedidoProduto = new PedidoProduto();
        $pedidoProduto->pedido_id = $pedido->id;
        $pedidoProduto->produto_id = $request->get('produto_id');
        $pedidoProduto->quantidade = $request->get('quantidade');
        $pedidoProduto->save(); */

        $pedido->produtos()->attach(
            $request->get('produto_id'),
            ['quantidade' => $request->get('quantidade')]
        );

        return redirect()->route('pedido-produto.create', ['pedido' => $pedido->id]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PedidoProduto $pedidoProduto, $pedido_id)
    {
        //Criar função destroy
        /* $pedidoProduto = PedidoProduto::find($pedido->id, $produto->id);
        $pedidoProduto->delete();
        return redirect()->route('pedido-produto.create', ['pedido' => $pedidoProduto->pedido_id]); */

        //Criar função destroy pelo detach
        //$pedidoProduto->produtos()->detach($pedidoProduto->pivot->id);
        $pedidoProduto->delete();
        return redirect()->route('pedido-produto.create', ['pedido' => $pedido_id]);
    }
}
