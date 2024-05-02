@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bem-vindo ao Controle de Tarefas</div>

                <div class="card-body">
                    @auth
                        <p>Bem-vindo, {{ Auth::user()->name }}!</p>
                        <p>Você está logado no sistema.</p>
                        <a href="{{ route('tarefa.index') }}">Acessar Controle de Tarefas</a>
                    @endauth

                    @guest
                        <h3>Bem Vindo Visitante</h3>
                        <p>Se Cadastre ou faça login para acessar o Controle de Tarefas.</p>
                        <p>Aqui você criará Tarefas diárias para seu controle, esse sistema ajudará você da melhor forma possível</p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
@endsection