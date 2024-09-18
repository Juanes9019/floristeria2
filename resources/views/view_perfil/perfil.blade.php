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
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
                <div class="card-header">{{ __('Informacion') }}</div>
                <div class="card-body">
                    @if ($section == 'edit-info')
                        @include('view_perfil.editar_info')

                    @elseif ($section == 'historial')
                        @include('view_perfil.historial')

                    @elseif ($section == 'mispqrs')
                        @include('view_perfil.crear_pqrs')

                    @elseif ($section == 'historial_pqrs')
                        @include('view_perfil.historial_pqrs')                        

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

