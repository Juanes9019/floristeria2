@extends('adminlte::page')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@livewire('index-producto')

<!-- <style>

    /* Estilos para la tabla */
.table {
    border-collapse: separate;
    border-spacing: 0 8px;
}

.table th,
.table td {
    vertical-align: middle;
    text-align: center;
    padding: 12px;
}

.table-hover tbody tr:hover {
    background-color: #f2f2f2;
}

.table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

/* Alternar colores en las filas */
.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Estilos para las imágenes */
.thumbnail {
    width: 100px;
    height: 100px;
    border-radius: 8px;
    object-fit: cover;
}

/* Botones de acción */
.btn {
    padding: 5px 10px;
    margin: 2px;
    font-size: 14px;
    border-radius: 6px;
}

/* Mejorar alineación y espaciado del estado */
.btn-success, .btn-danger {
    font-weight: bold;
    padding: 6px 12px;
} -->

</style>

@stop