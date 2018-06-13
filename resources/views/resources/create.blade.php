@extends('adminlte::page')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Recursos</h2>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a class="btn btn-primary" href="{{ route('resources.index') }}"> Voltar</a>
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

        {!! Form::open(array('route' => 'resources.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Recursos:</strong>
                    {!! Form::select('resource', $resources, null, ['class' => 'form-control'] ) !!}
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