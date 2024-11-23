@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@livewire('historial_perdida-table')
@endsection