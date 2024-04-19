@extends('app.layouts.basico')

@section('titulo', 'Produto')
@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Listagem de Produtos</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href=" {{ route('produto.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 90%; margin-left: auto; margin-right: auto">
                <table border="1" width="100%" class="table table-striped table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Fornecedor</th>
                        <th>Peso</th>
                        <th>Comprimento</th>
                        <th>Altura</th>
                        <th>Largura</th>
                        <th>Unidade ID</th>
                        <th>Visualizar</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->descricao }}</td>
                            <td>{{ $produto->fornecedor->nome }}</td>
                            <td>{{ $produto->peso }}</td>
                            <td>{{ $produto->produtoDetalhe->comprimento ?? '' }}</td>
                            <td>{{ $produto->produtoDetalhe->altura ?? ''}}</td>
                            <td>{{ $produto->produtoDetalhe->largura ?? ''}}</td>
                            <td>{{ $produto->unidade_id }}</td>
                            <td><a href="{{ route('produto.show', ['produto' => $produto->id]) }}">Visualizar</a></td>
                            <td>
                                <a href="{{ route('produto.edit', ['produto' => $produto->id]) }}">Editar</a>
                            </td>
                            <td>
                                <form id="form_{{$produto->id}}" action="{{ route('produto.destroy', ['produto' => $produto->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    {{-- <button type="submit">Excluir</button>     --}}
                                    <a href="#" onclick="document.getElementById('form_{{$produto->id}}').submit()" >Excluir</a>
                                </form>    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
                {{ $produtos->appends($request)->links() }}
            </div>
        </div>
    </div>
@endsection