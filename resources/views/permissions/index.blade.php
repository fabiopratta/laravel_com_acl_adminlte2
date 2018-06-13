@extends('adminlte::page')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Permissoes</h2>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('user-create')
                    <a class="btn btn-success" href="{{ route('permissions.create') }}"> Atribuir nova Permissao</a>
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
                            <th>Papel</th>
                            <th>Recurso</th>
                            <th>Permissao</th>
                            <th width="280px">Acao</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($retorno as $key => $permission)
                            @foreach($permission['resources'] as $resource => $per)
                            <tr>
                                <td>{{$permission['role']->name}}</td>
                                <td>{{ucfirst($resource)}}</td>
                                <td>
                                    @foreach($per as $pp)
                                        <label class="badge badge-success">{{$permissionsShow[$pp]}}</label>
                                    @endforeach
                                </td>
                                <td>
                                    @can('permission-edit')
                                        <a href="{{ route('permissions.edit',$permission['role']->id."-".$resource) }}" class="btn btn-warning">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        </a>
                                    @endcan
                                    @can('permission-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission['role']->id."-".$resource],'style'=>'display:inline']) !!}
                                            <button type="submit" class="btn btn-danger">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
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