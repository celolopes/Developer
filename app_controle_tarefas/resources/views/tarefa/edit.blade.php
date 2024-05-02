@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Tarefa</div>

                <div class="card-body">
                    <form method="post" action="{{ route('tarefa.update', ['tarefa' => $tarefa->id])}}">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label">Tarefa</label>
                            <input type="text" class="form-control @error('tarefa') is-invalid @enderror" name="tarefa" value="{{ old('tarefa', $tarefa->tarefa) }}">
                            @error('tarefa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data limite conclusão</label>
                            <input type="date" class="form-control @error('data_limite_conclusao') is-invalid @enderror" name="data_limite_conclusao" value="{{ old('data_limite_conclusao', $tarefa->data_limite_conclusao) }}">
                            @error('data_limite_conclusao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <a href="{{url()->previous()}}" class="btn btn-primary">Voltar</a>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
