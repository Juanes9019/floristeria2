@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Error') }}</div>

                <div class="card-body">
                    <p>Lo sentimos, ha ocurrido un problema y no podemos mostrar la página que estás buscando.</p>
                    <p>Si crees que esto es un error, por favor, contacta al soporte técnico.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection