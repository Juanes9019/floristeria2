@extends('adminlte::page')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de proveedores</b>
                        </span>

                        <div class="float-right">
                            <a href="{{ route('Admin.proveedor.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('Registrar un proveedor') }}
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
                                    <th class="text-center">Teléfono</th>
                                    <th class="text-center">Correo</th>
                                    <th class="text-center">Ubicacion</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proveedores as $proveedor)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">{{ $proveedor->nombre }}</td>
                                    <td class="text-center">{{ $proveedor->telefono }}</td>
                                    <td class="text-center">{{ $proveedor->correo }}</td>
                                    <td class="text-center">{{ $proveedor->ubicacion }}</td>
                                    <td class="text-center">{{ $proveedor->estado == 1 ? 'Activo': 'Inactivo' }} </td>

                                    <td class="text-center">
                                        <form id="form_eliminar_{{ $proveedor->id }}" action="{{ route('Admin.proveedor.destroy', $proveedor->id) }}" method="POST">
                                            <a class="btn btn-sm btn-warning" href="{{ route('Admin.proveedor.edit', ['id' => $proveedor->id]) }}">
                                                <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{ $proveedor->id }}')">
                                                <i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}
                                            </button>
                                            <a class="btn btn-sm {{ $proveedor->estado == 1 ? 'btn-success' : 'btn-danger' }}" href="{{ route('Admin.proveedor.status', $proveedor->id) }}">
                                                {{ $proveedor->estado == 1 ? 'Activo' : 'Inactivo' }}
                                                <i class="fa fa-fw fa-sync"></i>
                                            </a>
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

<script>
    function eliminar(proveedorId) {
        Swal.fire({
            title: "¡Estas seguro!",
            text: "¿Deseas Eliminar este proveedor?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "!Proveedor Eliminado!",
                    text: "El proveedor se Eliminó Correctamente",
                    icon: "success"
                }).then(() => {
                    document.getElementById('form_eliminar_' + proveedorId).submit();
                });
            }
        });
    }
</script>

@stop