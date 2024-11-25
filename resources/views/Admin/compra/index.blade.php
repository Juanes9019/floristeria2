@extends('adminlte::page')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@livewire('compra-table')
@stack('scripts')

@stop