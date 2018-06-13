@extends('adminlte::page')
 
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Roles</h2>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('permission-create')
                    <a class="btn btn-success" href="{{ route('roles.create') }}"> Criar Papel</a>
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
                            <th>ID</th>
                            <th>Role</th>
                            <th width="280px">Acao</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @can('role-edit')
                                    <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-warning">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                @endcan
                                @can('role-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
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

{!! $roles->render() !!}

@endsection