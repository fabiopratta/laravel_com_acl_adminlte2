@extends('adminlte::page')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Clientes</h2>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a class="btn btn-primary" href="{{ route('clientes.index') }}"> Voltar</a>
            </div>
        </div>
    </div>


    @if (count($errors) > 0)
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
    @endif

    <div class="wrapper wrapper-content">
        <div class="animated fadeInRightBig">
            <div class="ibox-content">

            {!! Form::open(array('route' => 'clientes.store','method'=>'POST')) !!}
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>CNPJ:</strong>
                            {!! Form::text('cnpj', '',["class" => 'form-control cnpj','id' => 'cnpj','autocomplete' => 'cnpj'] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nome:</strong>
                            {!! Form::text('nome', '',["class" => 'form-control','id' => 'nome','autocomplete' => 'name'] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Telefone:</strong>
                            {!! Form::text('telefone', '',["class" => 'form-control','id' => 'telefone','autocomplete' => 'phone'] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            {!! Form::text('email', '',["class" => 'form-control','id' => 'email','autocomplete' => 'email'] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>CEP:</strong>
                            {!! Form::text('cep', '',["class" => 'form-control cep_clientes','id' => 'cep','autocomplete' => 'postal-code', 'maxlength' => "9"] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Rua:</strong>
                            {!! Form::text('endereco', '',["class" => 'form-control','id' => 'endereco','autocomplete' => 'address-level1'] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Numero:</strong>
                            {!! Form::text('bairro', '',["class" => 'form-control','id' => 'numero'] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Bairro:</strong>
                            {!! Form::text('numero', '',["class" => 'form-control','id' => 'bairro',] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Cidade:</strong>
                            {!! Form::text('cidade', '',["class" => 'form-control','id' => 'cidade',] ) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {!! Form::text('estado', '',["class" => 'form-control','id' => 'estado',] ) !!}
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
        {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection