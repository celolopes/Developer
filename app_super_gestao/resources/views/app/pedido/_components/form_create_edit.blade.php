@if(isset($pedido->id))
    <form method="post" action="{{route('pedido.update', ['pedido' => $pedido->id])}}">
    @method('PUT')
@else
    <form method="post" action=" {{ route('pedido.store') }}">
@endif
        <input type="hidden" name="id" value="{{ $pedido->id ?? '' }} ">
        @csrf
        <select name="cliente_id" class="borda-preta">
            <option value="">Selecionar o Cliente</option>
            @foreach ($clientes as $cliente)
            <option value="{{ $cliente->id }}" {{ ($pedido->cliente_id ?? old('cliente_id')) == $cliente->id ? 'selected' : '' }} >{{ $cliente->nome }}</option>
            @endforeach
        </select>
        {{ $errors->has('cliente_id') ? $errors->first('cliente_id') : '' }}
        
        @if(isset($pedido->id))
        <button type="submit" class="borda-preta">Atualizar</button>
        @else
        <button type="submit" class="borda-preta">Adicionar</button> 
        @endif
    </form>