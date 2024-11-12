@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

    <div class="fondo-imagen">
        <img src="{{ asset('img/logo.png') }}">
    </div>
    <style>
        .fondo-imagen img {
  width: 100%; /* O el porcentaje o valor que desees */
  height: auto; /* Mantiene la proporción de la imagen */
  object-fit: cover; /* Ajusta cómo se muestra la imagen */
  position: relative; /* Para que se posicione correctamente en relación al contenedor */

  opacity: 0.5;
}
    </style>
@endsection

@section('content')
    
@endsection
