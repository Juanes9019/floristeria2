@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de PQRS</b>
                        </span>
                    </div>
                </div>  

                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: '{{ session('success') }}',
                            position: 'top-end',
                            toast: true,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    </script>
                @elseif (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '{{ session('error') }}',
                            position: 'top-end',
                            toast: true,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    </script>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        @if($pqrs->isEmpty())
                            <div class="alert alert-warning">
                                No hay registros de PQRS.
                            </div>
                        @else
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">user_id</th>
                                        <th class="text-center">estado</th>
                                        <th class="text-center">fecha_envio</th>
                                        <th class="text-center">tipo</th>
                                        <th class="text-center">motivo</th>
                                        <th class="text-center">respuesta</th>
                                        <th class="text-center">fecha_respuesta</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pqrs as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->user_id }}</td>
                                        <td class="text-center">{{ $item->estado }}</td>
                                        <td class="text-center">{{ $item->fecha_envio }}</td>
                                        <td class="text-center">{{ $item->tipo }}</td>
                                        <td class="text-center">{{ $item->motivo }}</td>
                                        <td class="text-center">{{ $item->respuesta }}</td>
                                        <td class="text-center">{{ $item->fecha_respuesta }}</td>
                                        <td class="text-center">
                                            @if($item->estado == "Respondido")
                                                <button type="button" class="btn btn-success" disabled>
                                                    <i class="fas fa-reply"></i> {{ __('Respondido') }}
                                                </button>
                                            @elseif($item->estado == "Nuevo")
                                                <button type="button" class="btn btn-success" data-id="{{ $item->id }}" data-toggle="modal" data-target="#respuestaModal">
                                                    <i class="fas fa-reply"></i> {{ __('Responder') }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$pqrs->isEmpty())
    <div class="modal fade" id="respuestaModal" tabindex="-1" role="dialog" aria-labelledby="respuestaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="respuestaModalLabel">Respuesta de PQRS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pqrs.responder', $item->id ?? '') }}" id="respuestaForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="pqrId">

                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $fecha ?? '' }}" readonly>

                            <br>
                            
                            <label for="respuesta">Respuesta</label>
                            <textarea class="form-control" id="respuesta" name="respuesta" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    .centrar-formulario {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@stop
