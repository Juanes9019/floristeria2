@extends('adminlte::page')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                <b>Control de Permisos y Roles</b>
                            </span>
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
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Rol</th>
                                        <th scope="col" class="text-center">Permisos</th>
                                        <th scope="col" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $role->nombre }}</td>
                                            <td class="text-center">{{ $role->permisos->pluck('nombre')->implode(', ') }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-success" data-id="{{ $role->id }}" data-toggle="modal" data-target="#respuestaModal{{ $role->id }}">
                                                    <i class="fas fa-reply"></i> {{ __('Editar Permisos') }}
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="respuestaModal{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="respuestaModalLabel{{ $role->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="respuestaModalLabel{{ $role->id }}">Permisos para {{ $role->nombre }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('permisos.update', ['id' => $role->id]) }}" method="post">
                                                            @csrf  
                                                            @method('PUT')
                                                        
                                                            @foreach($todos_los_permisos as $permiso)
                                                                <input 
                                                                    type="checkbox" 
                                                                    name="permisos[]" 
                                                                    value="{{ $permiso->id }}"
                                                                    {{ $role->permisos->contains($permiso->id) ? 'checked' : '' }}> 
                                                                <label for="permiso_{{ $permiso->id }}">{{ $permiso->nombre }}</label> <!-- Aquí obtenemos el nombre de la tabla permisos -->
                                                                <br>
                                                            @endforeach
                                                        
                                                            <button type="submit" class="btn btn-outline-secondary">Guardar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: "{{ session('success') }}",
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif

@stop
