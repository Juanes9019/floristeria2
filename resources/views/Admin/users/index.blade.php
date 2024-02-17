@extends('adminlte::page')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                <b>Control de usuarios</b>
                            </span>

                            <div class="float-right">
                                <a href="{{ route('Admin.users.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Registrar un usuario') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th class="text-center">No</th>

                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Correo</th>
                                        <th class="text-center">Rol</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($usuarios as $user)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center">{{ $user->email }}</td>
                                        <td class="text-center">{{ $user->type }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('Admin.users.destroy', $user->id) }}"
                                                        method="POST">                                                
                                                <a class="btn btn-sm btn-success"
                                                    href="{{ route('Admin.users.edit', ['id' => $user->id]) }}"><i
                                                        class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .centrar-formulario {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

@stop
