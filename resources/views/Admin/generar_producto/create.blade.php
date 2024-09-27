@extends('adminlte::page')

@section('content')
<div class="container">
    <h2>Crear Producto</h2>

    <form action="{{ route('Admin.productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Producto</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="id_categoria">Categoría</label>
            <select class="form-control" name="id_categoria" required>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" required></textarea>
        </div>

        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control" name="foto" required>
        </div>

        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" class="form-control" name="precio" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" name="estado" required>
                <option value="0">Inactivo</option>
                <option value="1">Activo</option>
            </select>
        </div>

        <!-- Formulario para detalles del producto -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">Detalles del Producto:</div>
            <div class="card-body">
                <form action="{{ route('admin.generar_producto.create') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Producto:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría del Producto:</label>
                        <select id="categoria" name="categoria_id" class="form-select" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias_insumos as $categoria_insumo)
                            <option value="{{ $categoria_insumo->id }}">{{ $categoria_insumo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Producto</button>
                </form>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Crear Producto</button>
    </form>
</div>
@endsection