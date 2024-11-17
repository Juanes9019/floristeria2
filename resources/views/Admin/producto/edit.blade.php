@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

@livewire('producto.edit-producto',['id' => $producto->id])
@vite('resources/css/app.css')

@stop