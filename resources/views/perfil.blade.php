{{-- resources/views/perfil.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <fieldset class="row">
        <div class="container text-black-50 row">
            <div class="col-6 row justify-content-center">
                <div class="align-items-center col-auto">
                    <fieldset>
                        <div class="row">
                            <img id="image" class="form-control img-thumbnail" height="300" src="{{ asset('images/profile.jpg') }}" alt="Profile Image" />
                        </div>
                        <br />
                        <div class="row">
                            <input type="file" id="FUImage" class="form-control form-control-sm" />
                        </div>
                        <br />
                        <div class="row">
                            <button id="BtnAplicar" class="form-control btn btn-outline-info" onclick="applyChanges()">Aplicar Cambios</button>
                        </div>
                    </fieldset>
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" id="darkModeSwitch" onchange="toggleDarkMode()">
                        <label class="form-check-label" for="darkModeSwitch">Modo Oscuro</label>
                    </div>
                </div>
                <div class="row">
                    <label class="alert-danger" id="lblError"></label>
                </div>
            </div>
            <div class="col-6 row justify-content-center">
                <div class="align-items-center col-auto">
                    <fieldset>
                        <legend>
                            <h3>Datos personales</h3>
                        </legend>
                        <table>
                            <tr>
                                <td>
                                    <label class="col-form-label">Nombres:</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="tbNombres" value="{{ $user->name }}" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="col-form-label">Apellidos:</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="tbApellidos" value="{{ $user->surname }}" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="col-form-label">Celular:</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="tbCelular" value="{{ $user->celular }}" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="col-form-label">Direccion:</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="tbDireccion" value="{{ $user->direccion }}" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="col-form-label">Rol:</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="tbDireccion" value="{{ $user->id_rol }}" />
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <br />
                </div>
            </div>
        </div>
    </fieldset>
    <br />
    <br />
</div>
@endsection
