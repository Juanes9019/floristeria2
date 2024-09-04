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
                    @php $isActive = $activeSection === 'edit-info'; @endphp
                    <a href="{{ route('perfilUser', 'edit-info') }}" class="btn @if ($isActive) btn-primary @else btn-outline-primary @endif d-block mb-2 w-100">Editar información</a>
            
                    @php $isActive = $activeSection === 'historial'; @endphp
                    <a href="{{ route('perfilUser', 'historial') }}" class="btn @if ($isActive) btn-primary @else btn-outline-primary @endif d-block mb-2 w-100">Historial de pedidos</a>
            
                    @php $isActive = $activeSection === 'mispqrs'; @endphp
                    <a href="{{ route('perfilUser', 'mispqrs') }}" class="btn @if ($isActive) btn-primary @else btn-outline-primary @endif d-block mb-2 w-100">Nueva PQRS</a>
            
                    @php $isActive = $activeSection === 'historial_pqrs'; @endphp
                    <a href="{{ route('perfilUser', 'historial_pqrs') }}" class="btn @if ($isActive) btn-primary @else btn-outline-primary @endif d-block mb-2 w-100">Mis PQRS</a>
                </div>
            </div>
        </div>

        <div class="col-md-7 full-height">
            <div class="card h-100">
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif
                <div class="card-header">{{ __('Informacion') }}</div>
                <div class="card-body">
                    @if ($section == 'edit-info')
                    <form id="formulario_informacion" method="POST" action="{{ route('update_informacion') }}" novalidate>
                        @csrf

                        <div class="form-group">
                            <label for="tbNombres" class="col-form-label">Nombres:</label>
                            <input type="text" name="name" class="form-control" id="tbNombres" value="{{ $user->name }}" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="tbApellidos" class="col-form-label">Apellidos:</label>
                            <input type="text" name="surname" class="form-control" id="tbApellidos" value="{{ $user->surname }}" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="tbCelular" class="col-form-label">Celular:</label>
                            <input type="text" name="celular" class="form-control" id="tbCelular" value="{{ $user->celular }}" />
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="tbDireccion" class="col-form-label">Dirección:</label>
                            <input type="text" name="direccion" class="form-control" id="tbDireccion" value="{{ $user->direccion }}" />
                        </div>

                        <br>

                        <div class="form-group text-center">
                            <button type="submit" id="BtnAplicar" class="btn btn-warning mt-3">Aplicar Cambios</button>
                        </div>
                    </form>

                    @elseif ($section == 'historial')
                        @include('view_perfil.historial')

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

