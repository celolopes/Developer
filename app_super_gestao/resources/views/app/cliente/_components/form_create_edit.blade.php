@if(isset($cliente->id))
    <form method="post" action="{{route('cliente.update', ['cliente' => $cliente->id])}}">
    @method('PUT')
@else
    <form method="post" action=" {{ route('cliente.store') }}">
@endif
        <input type="hidden" name="id" value="{{ $cliente->id ?? '' }} ">
        @csrf
        <input type="text" name="nome" value="{{ $cliente->nome ?? old('nome') }}" placeholder="Nome" class="borda-preta">
        {{ $errors->has('nome') ? $errors->first('nome') : '' }}
        
        @if(isset($cliente->id))
        <button type="submit" class="borda-preta">Atualizar</button>
        @else
        <button type="submit" class="borda-preta">Adicionar</button> 
        @endif
    </form>