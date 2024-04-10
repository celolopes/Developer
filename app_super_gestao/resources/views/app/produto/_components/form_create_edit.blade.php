@if(isset($produto->id))
    <form method="post" action="{{route('produto.update', ['produto' => $produto->id])}}">
    @method('PUT')
@else
    <form method="post" action=" {{ route('produto.store') }}">
@endif   
        <input type="hidden" name="id" value="{{ $produto->id ?? '' }} ">
        @csrf
        <input type="text" name="nome" value="{{ $produto->nome ?? old('nome') }}" placeholder="Nome" class="borda-preta">
        {{ $errors->has('nome') ? $errors->first('nome') : '' }}
        <input type="text" name="descricao" value="{{ $produto->descricao ?? old('descricao') }}" placeholder="Descrição" class="borda-preta">
        {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
        <input type="text" name="peso" value="{{ $produto->peso ?? old('peso') }}" placeholder="Peso" class="borda-preta">
        {{ $errors->has('peso') ? $errors->first('peso') : '' }}         
        
        <select name="unidade_id" class="borda-preta">
            <option value="">Selecionar a Unidade de Medida</option>
            @foreach ($unidades as $key => $unidade)
            <option value="{{ $unidade->id }}" {{ $produto->unidade_id ?? old('unidade_id') == $unidade->id ? 'selected' : '' }}>{{ $unidade->descricao }}</option>
            @endforeach
        </select>
        {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}
        @if(isset($produto->id))
        <button type="submit" class="borda-preta">Atualizar</button>
        @else
        <button type="submit" class="borda-preta">Adicionar</button> 
        @endif
    </form>