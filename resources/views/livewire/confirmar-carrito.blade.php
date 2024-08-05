<div class="container mt-5">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submit">
            <div class="form-group">
                <label for="nombre_destinatario">Nombre del destinatario</label>
                <input type="text" class="form-control" id="nombre_destinatario" wire:model.debounce.500ms="nombre_destinatario">
                @error('nombre_destinatario') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>

            <br>

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" wire:model.debounce.500ms="fecha" readonly>
                @error('fecha') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>

            <br>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" wire:model.debounce.500ms="direccion">
                @error('direccion') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>

            <br>

            <div class="form-group">
                <label for="instrucciones_entrega">Instrucciones de entrega</label>
                <input type="text" class="form-control" id="instrucciones_entrega" wire:model.debounce.500ms="instrucciones_entrega">
                @error('instrucciones_entrega') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>

            <br>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" wire:model.debounce.500ms="telefono">
                @error('telefono') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>

            <br>

            <div class="text-center">
                <label for="telefono">Metodo de pago:</label>
                <label for="telefono">Transferencia/QR:</label>
                <img src="{{ asset('img/qr.jpg') }}" class="img-fluid mx-auto d-block" style="max-width: 200px;" alt="Código QR">
            </div>

            <br>

            <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
    </div>
</div>
