@extends('layouts.app')

@section('content')

<div class="container" style="width: 90%; max-width: 1300px;">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header text-black" style="background-color: #FFB6C1;">{{ __('Arreglo personalizado desde cero') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="alert alert-primary text-dark">En esta sección, puedes de diseñar un arreglo personalizado desde cero, eligiendo entre una amplia variedad de flores y productos disponibles. </p>

                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#insumoModal"><i class="fas fa-box-open"></i> Personalizar producto</button>
                    </div>


                    @include('view_arreglo.personalizado.cero')
                    
                </div>
            </div>
        </div>

        <!-- personalizado estandar -->
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header text-black" style="background-color: #FFB6C1;">{{ __('Arreglo Personalizado en base a un producto') }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="alert alert-primary text-dark">En esta sección, puedes crear un arreglo personalizado basado en uno ya establecido. Tendrás la opción de cambiar las flores o agregar más elementos.</p>

                    <div class="d-flex justify-content-between mb-4">
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal_producto_nuevo"><i class="fas fa-edit"></i> Personalizar producto predeterminado</button>
                    </div>

                    @include('view_arreglo.personalizado.estandar')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
