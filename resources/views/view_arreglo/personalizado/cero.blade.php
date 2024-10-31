<div class="row mt-4">  
    <div class="card-header text-black rounded ml-3 mb-3" style="background-color: #FFB6C1; width: 95%;">Selecciona los productos que deseas:</div>
    <div class="col-md-6">
        <div class="p-4 bg-light border rounded shadow-sm"> 
            <form action="{{ route('agregar_producto') }}" method="POST">
                @csrf
                <label for="categoria">Selecciona la categoría que desea:</label>
                <select id="categoria" name="categoria_id" class="form-select">
                    <option value="">Selecciona la categoría</option>
                    @foreach($categorias_insumo as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>

                <label for="producto" class="mt-3">Selecciona el producto:</label>
                <select id="producto" name="insumo_id" class="form-select" disabled>
                    <option value="">Selecciona un producto</option>
                </select>

                <label for="cantidad" class="mt-3">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1">
                <button type="submit" class="btn btn-primary mt-3">Agregar Insumo</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-6">
    <div class="d-flex flex-column align-items-center" style="height: 100%;">
        <div id="imagen-insumo-container" class="bg-light border rounded shadow-sm p-3 mb-3 text-center" style="display: none; width: 100%; height: 200px;">
            <img id="imagen-insumo" src="ruta/default.jpg" alt="imagen producto" class="img-fluid" style="max-height: 100%; object-fit: contain;">
        </div>
        
        <div id="precio-insumo" class="bg-light border rounded shadow-sm  mb-2" style="width: 100%;">
            <h5 class="mb-0">Precio: <span id="precio-value">$0</span></h5>
        </div>
        
        <div id="descripcion-insumo" class="bg-light border rounded shadow-sm p-3" style="width: 100%;">
            <h6 class="mb-0">Descripción:</h6>
            <p class="mb-0">Por favor selecciona un insumo para ver más detalles.</p>
        </div>
    </div>
</div>

</div>

</div>

<script>
    document.getElementById('producto').addEventListener('change', function() {
        const imagenContainer = document.getElementById('imagen-insumo-container');
        const selectedValue = this.value;

        if (selectedValue) {
            imagenContainer.style.display = 'block'; 
        } else {
            imagenContainer.style.display = 'none'; 
        }
    });
</script>
