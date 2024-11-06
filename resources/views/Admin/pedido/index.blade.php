@extends('adminlte::page')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewire('pedidos-table')
    @stack('scripts')

@stop