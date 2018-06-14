@extends('adminlte::page')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Recursos</h2>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('resource-create')
                    <a class="btn btn-success" href="{{ route('resource.create') }}"> Adicionar Recurso</a>
                @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <script>
            setTimeout(function(){
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 6000
                };
                toastr.success('{{$message}}','Sucesso:');
            },1000);
        </script>
    @endif

    <div class="wrapper wrapper-content">
        <div class="animated fadeInRightBig">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                        <tr>
                            <th>Recurso</th>
                            <th width="280px">Acao</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($resources as $key => $resource)
                            <tr>
                                <td>{{ $resource}}</td>
                                <td>
                                    @can('resource-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['resource.destroy', $key],'style'=>'display:inline']) !!}
                                            <button type="submit" class="btn btn-danger">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <script>
            setTimeout(function(){
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 6000
                };
                toastr.success({{$message}},'Sucesso:');
            },1000);
        </script>
    @endif

@endsection