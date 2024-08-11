@extends('layouts.app')

@section('content')
<div class="container-fluid full-height mt-4">
    <div class="row justify-content-center full-height g-3"> 
        <div class="col-md-3 full-height d-flex flex-column">
            <div class="card mb-3 flex-grow-4 text-center">
                <div class="card-body">
                    <img src="{{ asset('img/perfil.png') }}" class="img-fluid mx-auto d-block" style="max-width: 200px;">
                    <div class="mt-3">
                        <label class="d-block">Rol</label>
                        <label class="d-block">{{ $rol }}</label>
                    </div>
                </div>
                <div class="row mt-3">
                    <label class="alert-danger" id="lblError"></label>
                </div>
            </div>
            <div class="card flex-grow-1 mb-3"> 
                <div class="card-header text-center">{{ __('Menu del perfil') }}</div>
                <div class="card-body option-list">
                    <a href="{{ route('perfilUser', 'edit-info') }}" class="btn d-block mb-2 w-100" style="background-color: #e05e7c; color: black;">Editar información</a>
                    <a href="{{ route('perfilUser', 'historial') }}" class="btn d-block mb-2 w-100" style="background-color: #e05e7c; color: black;">Historial de pedidos</a>
                    <a href="{{ route('perfilUser', 'favoritos') }}" class="btn d-block mb-2 w-100" style="background-color: #e05e7c; color: black;">
                        <i class="fas fa-heart" style="color: red;"></i> Favoritos
                    </a>
                    <a href="{{ route('perfilUser', 'mispqrs') }}" class="btn d-block mb-2 w-100" style="background-color: #e05e7c; color: black;">Mis PQRS</a>
                    <a href="{{ route('perfilUser', 'historial_pqrs') }}" class="btn d-block mb-2 w-100" style="background-color: #e05e7c; color: black;">Historial PQRS</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 full-height">
            <div class="card h-100">
                <div class="card-header">{{ __('Informacion') }}</div>
                <div class="card-body">
                    @if ($section == 'edit-info')
                    <table class="table">
                        <tr>
                            <td><label class="col-form-label">Nombres:</label></td>
                            <td><input type="text" class="form-control" id="tbNombres" value="{{ $user->name }}" /></td>
                        </tr>
                        <tr>
                            <td><label class="col-form-label">Apellidos:</label></td>
                            <td><input type="text" class="form-control" id="tbApellidos" value="{{ $user->surname }}" /></td>
                        </tr>
                        <tr>
                            <td><label class="col-form-label">Celular:</label></td>
                            <td><input type="text" class="form-control" id="tbCelular" value="{{ $user->celular }}" /></td>
                        </tr>
                        <tr>
                            <td><label class="col-form-label">Direccion:</label></td>
                            <td><input type="text" class="form-control" id="tbDireccion" value="{{ $user->direccion }}" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button id="BtnAplicar" class="btn btn-warning mt-3">Aplicar Cambios</button>
                            </td>
                        </tr>
                    </table>

                    @elseif ($section == 'historial')
                        @include('view_perfil.historial')

                    @elseif ($section == 'favoritos')
                    <h3>favoritos</h3>

                    @elseif ($section == 'mispqrs')
                        <h3>Mis PQRS</h3>

                    @elseif ($section == 'historial_pqrs')
                    <h3>Historial PQRS</h3>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

