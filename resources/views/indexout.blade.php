@extends('adminlte::page')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Permission Management</h2>
        </div>
        <div class="pull-right">
        @can('permission-create')
            <a class="btn btn-success" href="{{ route('permissions.create') }}"> Create New Permission</a>
            @endcan
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<table class="table table-striped table-bordered table-hover dataTables">
    <thead>
      <tr>
         <th>ID</th>
         <th>Nome</th>
         <th width="280px">Acao</th>
      </tr>
    </thead>
      <tbody>
        @foreach ($permissions as $key => $permission)
        <tr>
            <td>{{ $permission->id }}</td>
            <td>{{ $permission->name }}</td>
            <td>
                <a class="btn btn-info" href="{{ route('permissions.show',$permission->id) }}">Show</a>
                @can('role-edit')
                    <a class="btn btn-primary" href="{{ route('permissions.edit',$permission->id) }}">Edit</a>
                @endcan
                @can('role-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @endforeach
      </tbody>
</table>

{!! $permissions->render() !!}

@endsection