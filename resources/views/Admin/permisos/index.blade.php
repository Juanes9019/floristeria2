@extends('adminlte::page')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                <b>Control de Permisos y Roles</b>
                            </span>
                            <div class="float-right">
                                <a href="{{ route('Admin.roles.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    {{ __('Registrar rol') }}
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
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Rol</th>
                                        <th scope="col" class="text-center">Permisos</th>
                                        <th scope="col" colspan="2" class="text-center">Acciones</th>
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
                                                    <i class="fa fa-fw fa-edit"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('Admin.roles.destroy', ['id' => $role->id]) }}" method="POST">
                                                    
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        @foreach($roles as $role)
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
                
                    <!-- Campo para modificar el nombre del rol -->
                    <div class="form-group">
                        <label for="nombre_rol">Nombre del Rol</label>
                        <input type="text" name="nombre_rol" class="form-control" value="{{ $role->nombre }}" required>
                    </div>
                
                    <!-- Lista de permisos -->
                    <div class="form-group checkboxes-container">
                        @foreach($todos_los_permisos as $permiso)
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="permisos[]" value="{{ $permiso->id }}" 
                            {{ $role->permisos->contains($permiso->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permiso_{{ $permiso->id }}">{{ $permiso->nombre }}</label>
                        </div>
                        @endforeach
                    </div>
                
                    <button type="submit" class="btn btn-outline-secondary">Guardar</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endforeach

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
        .checkboxes-container {
    display: flex;
    flex-wrap: wrap;
}

.checkboxes-container .form-check {
    width: 50%;
}

    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Verificar si hay un nuevo rol creado en la sesión
        @if(session('new_role_id'))
            console.log('Sesión contiene new_role_id: {{ session('new_role_id') }}'); // Mensaje de depuración
            $('#respuestaModal{{ session('new_role_id') }}').modal('show'); // Mostrar modal del rol recién creado
        @else
            console.log('No se encontró new_role_id en la sesión.');
        @endif
    });
</script>
@stop
