@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<!-- link para sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<h2 class="text-center mb-5">Crear Proveedor</h2>
@livewire('create-proveedor')
@stop