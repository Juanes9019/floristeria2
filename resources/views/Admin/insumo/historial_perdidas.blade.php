@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class=" container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Historial de Pérdidas</b>
                        </span>
                    </div>
                </div>

                <div class="card-body">

                @if ($errors->has('status'))
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first('status') }}
                    </div>
                @endif

                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: '{{ session('success') }}',
                            position: 'top-end',
                            toast: true,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                @endif
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Exportar
                        </button>
                        <a href="{{ route('Admin.insumo') }}" class="btn btn-primary">Insumos</a>
                        <a href="{{ route('Admin.insumo.perdida') }}" class="btn btn-primary"data-placement="left">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="exportDropdown">
                            <a class="dropdown-item" href="{{ route('Admin.insumos.exportPerdida', ['format' => 'xlsx']) }}">
                                {{ __('Exportar a Excel') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('Admin.insumos.exportPerdida', ['format' => 'pdf']) }}">
                                {{ __('Exportar a PDF') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Insumo</th>
                                    <th class="text-center">Cantidad Pérdida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($historialPerdidas->isEmpty())  
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <div class="alert alert-warning">No hay perdidas registradas.</div>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($historialPerdidas as $perdida)
                                        <tr>
                                            <td class="text-center">{{ $perdida->fecha_perdida }}</td>
                                            <td class="text-center">{{ $perdida->insumo->nombre }}{{ $perdida->insumo->color ? ' - ' . $perdida->insumo->color : '' }}</td>
                                            <td class="text-center">{{ $perdida->cantidad_perdida }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <label>Páginas</label>
                        <select wire:model.live="porPagina">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
