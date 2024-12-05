<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de Productos</b>
                        </span>
                    </div>
                </div>

                @if ($message = Session::get('error'))
                <script>
                    Swal.fire({
                        title: '¡Error!',
                        text: '{{ $message }}',
                        icon: 'error',
                        position: 'top-end',
                        toast: true,
                        showConfirmButton: false,
                        timer: 5000
                    });
                </script>
                @endif

                @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: '{{ $message }}',
                        position: 'top-end',
                        toast: true,
                        showConfirmButton: false,
                        timer: 5000
                    });
                </script>
                @endif

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>

                        <div class="d-flex">
                            <div class="dropdown mr-2">

                            </div>
                            <a href="{{ route('Admin.producto.create') }}" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                    <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover  table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">Foto</th>
                                <th scope="col" class="text-center" wire:click="sortBy('nombre')">
                                    Nombre
                                    @if ($ordenarColumna === 'nombre')
                                    @if ($ordenarForma === 'asc')
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                    </svg>
                                    @else
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                    @endif
                                    @else
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                    </svg>
                                    @endif
                                </th>
                                <th scope="col" class="text-center">Categoria Producto</th>
                                <th scope="col" class="text-center">Descripción</th>
                                <th scope="col" class="text-center" wire:click="sortBy('precio')">
                                    Precio
                                    @if ($ordenarColumna === 'precio')
                                    @if ($ordenarForma === 'asc')
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                    </svg>
                                    @else
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                    @endif
                                    @else
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                    </svg>
                                    @endif
                                </th>
                                <th scope="col" class="text-center" wire:click="sortBy('estado')">
                                    Estado
                                    @if ($ordenarColumna === 'estado')
                                    @if ($ordenarForma === 'asc')
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                    </svg>
                                    @else
                                    <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                    @endif
                                    @else
                                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                    </svg>
                                    @endif
                                </th>
                                <th scope="col" class="text-center" colspan="3">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($productos as $producto)
                            <tr>
                                <td class="align-middle text-center">
                                    <img src="{{ $producto->foto }}" class="img-fluid" alt="Foto" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;" loading="lazy">
                                </td>
                                <td class="align-middle text-center">{{ $producto->nombre }}</td>
                                <td class="align-middle text-center">{{$producto->categoria_producto->nombre}}</td>
                                <td class="align-middle text-center">{{$producto->descripcion_limitada}}</td>
                                <td class="align-middle text-center">{{ number_format($producto->precio, 0, ',', '.') }}</td>
                                <td class="align-middle text-center">
                                    <a class="btn btn-sm {{ $producto->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                        wire:click="changeStatus({{ $producto->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="changeStatus({{ $producto->id }})"
                                        style="cursor: pointer;">
                                        {{ $producto->estado == 1 ? 'Activo' : 'Inactivo' }}
                                        <i class="fas fa-toggle-{{ $producto->estado == 1 ? 'on' : 'off' }}"></i>
                                    </a>

                                    <div wire:loading wire:target="changeStatus({{ $producto->id }})">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <!-- Botón de editar -->
                                        <a class="btn btn-sm btn-warning" href="{{ route('Admin.producto.edit', ['id' => $producto->id]) }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>

                                        <!-- Botón de eliminar -->
                                        <form id="form_eliminar_{{ $producto->id }}" action="{{ route('Admin.producto.destroy', ['id' => $producto->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{$producto->id}}','{{$producto->estado}}')">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </button>
                                        </form>

                                        <!-- Botón de ver -->
                                        <a class="btn btn-sm btn-primary btn-ver-detalle" data-url="{{ route('Admin.producto.show', ['id' => $producto->id]) }}">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </div>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <label>Páginas</label>
                    <select wire:model.live="porPagina">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                    <div class="mt-3">
                        {{ $productos->links() }}
                    </div>
                </div>
            </div>
            <!-- Modal base -->
            <div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="productoModalLabel">Detalle del Producto</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-content-loader" class="text-center my-4">
                                <i class="fa fa-spinner fa-spin fa-2x"></i>
                            </div>
                            <div id="modal-content-body" class="d-none"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        td .btn {
            margin: 0 5px;
            /* Espaciado entre botones */
        }

        img {
            max-width: 100px;
            /* Tamaño máximo de la imagen */
            height: auto;
        }
    </style>
</div>




<script>
    $(document).ready(function() {
        // Detectar clic en el botón de "Ver Detalle"
        $('.btn-ver-detalle').on('click', function(e) {
            e.preventDefault(); // Prevenir redirección

            // Obtener la URL del detalle del producto
            const url = $(this).data('url');

            // Limpiar contenido previo del modal
            $('#modal-content-loader').removeClass('d-none');
            $('#modal-content-body').addClass('d-none').html('');

            // Mostrar el modal
            $('#productoModal').modal('show');

            // Hacer la petición AJAX
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    // Actualizar el contenido del modal con la respuesta
                    $('#modal-content-loader').addClass('d-none');
                    $('#modal-content-body').removeClass('d-none').html(response);
                },
                error: function() {
                    $('#modal-content-loader').addClass('d-none');
                    $('#modal-content-body').removeClass('d-none').html('<p class="text-danger">Error al cargar los detalles del producto.</p>');
                }
            });
        });
    });



    function eliminar(productoId, estadoProducto) {
        if (estadoProducto == 1) {
            Swal.fire({
                title: "¡Error!",
                text: "No se puede eliminar un producto activo.",
                icon: "error",
                confirmButtonText: "OK"
            });
        } else {
            // Si la categoría no es activa, proceder a eliminar
            Swal.fire({
                title: "¡Estás seguro!",
                text: "¿Deseas eliminar esta categoría?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form_eliminar_${productoId}`).submit();
                }
            });
        }
    }
</script>