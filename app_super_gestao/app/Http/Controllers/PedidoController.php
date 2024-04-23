<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Cliar index de Pedidos com paginate 10
        $pedidos = Pedido::paginate(10);
        return view('app.pedido.index', ['pedidos' => $pedidos, 'request' => $request]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Criar função create de Pedido
        $clientes = Cliente::all();
        return view('app.pedido.create', ['clientes' => $clientes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Criar função de store de Pedidos com validates
        $request->validate([
            'cliente_id' => 'exists:clientes,id',
        ], [
            'cliente_id.exists' => 'O Cliente informado não existe',
        ]);

        $pedido = new Pedido();
        $pedido->cliente_id = $request->get('cliente_id');
        $pedido->save();

        return redirect()->route('pedido.index');
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
    public function destroy(string $id)
    {
        //
    }
}
