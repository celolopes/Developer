@extends('app.layouts.basico')

@section('titulo', 'Pedido')
@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Listagem de Pedido</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href=" {{ route('pedido.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 90%; margin-left: auto; margin-right: auto">
                <table border="1" width="100%" class="table table-striped table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th colspan=3>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->id_cliente }}</td>
                            <td><a href="{{ route('pedido.show', ['pedido' => $pedido->id]) }}">Visualizar</a></td>
                            <td>
                                <a href="{{ route('pedido.edit', ['pedido' => $pedido->id]) }}">Editar</a>
                            </td>
                            <td>
                                <form id="form_{{$pedido->id}}" action="{{ route('pedido.destroy', ['pedido' => $pedido->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    {{-- <button type="submit">Excluir</button>     --}}
                                    <a href="#" onclick="document.getElementById('form_{{$pedido->id}}').submit()" >Excluir</a>
                                </form>    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
                {{ $pedidos->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
@endsection

