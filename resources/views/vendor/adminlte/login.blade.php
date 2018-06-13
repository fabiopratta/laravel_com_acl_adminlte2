@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'gray-bg')

@section('body')
    @if ($errors->any())
        @php
            $message = ""
        @endphp

        @foreach ($errors->all() as $error)
            @php
                $message .= $error
            @endphp
        @endforeach
        <script>
            setTimeout(function(){
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 6000
                };
                toastr.error('{{$message}}','Erro:');
            },1000);
        </script>
    @endif

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div style="margin-left: -40px; margin-right: auto;">
                <h1 class="logo-name">SAGP</h1>
            </div>
            <h3>Bem Vindo</h3>
            <p>Sistema para gerenciamento de equipamentos</p>
            <p>Efetue login. e bom divertimento :-) </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" placeholder="Email:"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <input id="password" type="password" placeholder="Senha:"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                           required>
                </div>

                <div class="form-group row mb-0">
                    <button type="submit" class="btn btn-primary block full-width">
                        {{ __('Login') }}
                    </button>
                </div>

                <a href="{{ route('password.request') }}">
                    <small>Esqueceu sua senha?</small>
                </a>
            </form>
            <p class="m-t">
                <small>&copy; 2018 Todos direitos reservados</small>
                <br/>
                <a href="mailto:fabiobrotas@hotmail.com">Powered By Fabio Pratta</a>
            </p>
        </div>
    </div>
@stop

