@extends('adminlte::page')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Editar Papel</h2>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a class="btn btn-primary" href="{{ route('role.index') }}"> Voltar</a>
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
                {!! Form::model($role, ['method' => 'PATCH','route' => ['role.update', $role->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Nome:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection