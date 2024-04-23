<form method="post" action=" {{ route('pedido-produto.store', ['pedido' => $pedido]) }}">
        <input type="hidden" name="id" value="{{ $pedido->id ?? '' }} ">
        @csrf
        <select name="produto_id" class="borda-preta">
            <option value="">Selecionar o Produto</option>
            @foreach ($produtos as $produto)
            <option value="{{ $produto->id }}" {{ old('produto_id') == $produto->id ? 'selected' : '' }} >{{ $produto->nome }}</option>
            @endforeach
        </select>
        {{ $errors->has('produto_id') ? $errors->first('produto_id') : '' }}
        
        <button type="submit" class="borda-preta">Adicionar</button> 
    </form>