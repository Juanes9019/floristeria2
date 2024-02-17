@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Acceso Denegado') }}</div>

                <div class="card-body">
                    <p>Lo sentimos, pero parece que no tienes permiso para acceder a esta página.</p>
                    <p>Si crees que esto es un error, por favor, ponte en contacto con el administrador del sitio.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection