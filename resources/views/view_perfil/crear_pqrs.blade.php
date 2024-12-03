<h3>Mis PQRS</h3>

<div class="card card-body text-center">
    <p class="alert alert-primary text-dark">
        Las PQRS (Peticiones, Quejas, Reclamos y Sugerencias) son el medio que puedes utilizar para comunicar cualquier inconveniente, duda o sugerencia respecto a nuestros productos o servicios. Asegúrate de elegir el tipo de PQR adecuado para que podamos brindarte la mejor atención posible.
    </p>
</div>

<div class="card card-body">
    <form action="{{ route('pqrs') }}" method="post">
    @csrf
        <div class="form-group">
            <label for="fecha">Fecha: <strong style="color: red;">*</strong></label>
            <input type="date" class="form-control" id="fecha" name="fecha_envio" value="{{ $fecha }}" readonly>
        </div>

        <div class="form-group mt-3">
            <label for="tipo">Tipo de PQR:<strong style="color: red;">*</strong></label>
            <select class="form-control" id="tipo" name="tipo">
                <option value="">Selecciona el tipo</option>
                <option value="Peticiones">Peticiones</option>
                <option value="Quejas">Quejas</option>
                <option value="Reclamos">Reclamos</option>
                <option value="Sugerencia">Sugerencia</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="motivo">Motivo: <strong style="color: red;">*</strong></label>
            <select class="form-control" id="motivo" name="motivo">
                <option value="">Selecciona el motivo</option>
                <option value="Reembolso">Reembolso</option>
                <option value="Error en la página">Error en la página</option>
                <option value="Producto defectuoso">Producto defectuoso</option>
                <option value="Entrega tardía">Entrega tardía</option>
                <option value="Atención al cliente">Atención al cliente</option>
                <option value="Problema con el pago">Problema con el pago</option>
                <option value="Quejas sobre el servicio">Quejas sobre el servicio</option>
                <option value="Sugerencia de mejora">Sugerencia de mejora</option>
                <option value="Solicitud de cambio de producto">Solicitud de cambio de producto</option>
                <option value="Cancelación de pedido">Cancelación de pedido</option>
                <option value="Otros">Otros</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="descripcion">Descripción:<strong style="color: red;">*</strong></label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe tu PQR"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Enviar PQR</button>
    </form>
</div>