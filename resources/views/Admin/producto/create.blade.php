@extends('adminlte::page')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

@livewire('producto.create-producto')

<style>
    /* Aumenta la visibilidad de los bordes de todos los inputs */
    .form-control, 
    .form-select, 
    .form-check-input {
        border: 2px solid #6c757d; /* Borde más oscuro (gris oscuro) */
        border-radius: 5px; /* Suaviza las esquinas */
        box-shadow: none; /* Elimina cualquier sombra predeterminada */
    }
</style>

@stop