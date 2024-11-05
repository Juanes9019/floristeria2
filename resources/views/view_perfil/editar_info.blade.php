<form id="formulario_informacion" method="POST" action="{{ route('update_informacion') }}" novalidate>
@csrf

    <div class="form-group">
        <label for="tbNombres" class="col-form-label">Nombres:</label>
        <input type="text" name="name" class="form-control" id="tbNombres" value="{{ $user->name }}" />
    </div>

    <br>

    <div class="form-group">
        <label for="tbApellidos" class="col-form-label">Apellidos:</label>
        <input type="text" name="surname" class="form-control" id="tbApellidos" value="{{ $user->surname }}" />
    </div>

    <br>

    <div class="form-group">
        <label for="tbCelular" class="col-form-label">Celular:</label>
        <input type="text" name="celular" class="form-control" id="tbCelular" value="{{ $user->celular }}" />
    </div>

    <br>

    <div class="form-group text-center">
        <button type="submit" id="BtnAplicar" class="btn btn-warning mt-3">Aplicar Cambios</button>
    </div>
</form>