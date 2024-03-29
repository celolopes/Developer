@extends('site.layouts.basico')

@section('titulo', $titulo)
@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Login</h1>
        </div>

        <div class="informacao-pagina">
            <form action="{{ route('site.login') }}" method="POST">
                <div style="width:30%; margin-left:auto; margin-right:auto; ">
                    @csrf
                    <div class="form-group">
                        <input type="text" value="{{ old('usuario') }}" name="usuario" id="usuario" class="form-control" placeholder="Digite seu Usuário" class="borda-preta">
                        {{ $errors->has('usuario') ? $errors->first('usuario') : '' }}
                    </div>
                    <div class="form-group">
                        <input type="password" value="{{ old('password') }}" name="password" id="password" class="form-control" placeholder="Digite sua senha" class="borda-preta">
                        {{ $errors->has('password') ? $errors->first('password') : '' }}
                    </div>
                    <div class="form-group">
                        <button type="submit" class="borda-preta">Entrar</button>
                    </div>
                </div>    
            </form>
            {{ isset($erro) && $erro != '' ? $erro : '' }}
        </div>  
    </div>
    <div class="rodape">
        <div class="redes-sociais">
            <h2>Redes sociais</h2>
            <img src="{{ asset('img/facebook.png') }}">
            <img src="{{ asset('img/linkedin.png') }}">
            <img src="{{ asset('img/youtube.png') }}">
        </div>
        <div class="area-contato">
            <h2>Contato</h2>
            <span>(11) 3333-4444</span>
            <br>
            <span>supergestao@dominio.com.br</span>
        </div>
        <div class="localizacao">
            <h2>Localização</h2>
            <img src="{{ asset('img/mapa.png') }}">
        </div>
    </div>
@endsection