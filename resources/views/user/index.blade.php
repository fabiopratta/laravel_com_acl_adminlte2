@extends('adminlte::page')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Usuarios</h2>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @can('user-create')
                    <a class="btn btn-success" href="{{ route('user.create') }}"> Novo Usuario</a>
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
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th width="280px">Acao</th>
                        </tr>
                        </thead>
                        <tbody>
                         @foreach ($data as $key => $user)
                          <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                              @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                   <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                              @endif
                            </td>
                            <td>
                                @can('user-edit')
                                <a href="{{ route('user.edit',$user->id) }}" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </a>
                                @endcan

                                @can('user-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['user.destroy', $user->id],'style'=>'display:inline']) !!}
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

@endsection