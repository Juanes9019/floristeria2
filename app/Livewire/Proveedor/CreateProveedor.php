<?php

namespace App\Livewire\Proveedor;

use App\Models\Proveedor;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateProveedor extends Component
{
    public $tipo_proveedor = 'empresa'; // Valor predeterminado
    public $numero_documento, $nombre, $telefono, $correo, $ubicacion, $estado = 0; // Inicializa el estado en 0 (inactivo)

    public function mount()
    {
        // Si existe un valor previo para 'tipo', se usará, de lo contrario, 'empresa' será el valor por defecto
        $this->tipo_proveedor = old('tipo', 'empresa');
        // Si hay un valor previo para 'estado', lo asignamos
        $this->estado = old('estado', 0); 
    }

    // Este método se ejecuta al cambiar el valor de tipo_proveedor
    public function updatedTipoProveedor($value)
    {
        $this->tipo_proveedor = $value;
    }

    // Reglas de validación
    protected function rules()
    {
        $rules = [
            'tipo_proveedor' => 'required|in:empresa,persona',
            'nombre' => 'required|string|min:3|max:150', // Nombre con al menos 3 caracteres y máximo 150
            'numero_documento' => 'required|numeric|unique:proveedores,numero_documento', // Número de documento debe ser numérico y único
            'telefono' => 'required|min:10|max:15', // Teléfono requerido, solo números y entre 10 y 15 dígitos
            'correo' => 'required|email|regex:/^.+@.+$/i|max:255', // Correo debe tener @ y ser válido
            'ubicacion' => 'required|string|min:4|max:255', // Ubicación requerida y con al menos 4 caracteres
            'estado' => 'required|in:0,1', // Estado requerido, solo puede ser 0 o 1
        ];
        return $rules;
    }

    // Mensajes personalizados
    protected $messages = [
        'tipo_proveedor.required' => 'Debe seleccionar el tipo de proveedor.',
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
        'nombre.max' => 'El nombre no puede tener más de 150 caracteres.',
        'numero_documento.required' => 'El número de documento o NIT es obligatorio.',
        'numero_documento.numeric' => 'El número de documento o NIT debe ser numérico.',
        'numero_documento.unique' => 'El número de documento o NIT ya está registrado.',
        'telefono.required' => 'El teléfono es obligatorio.',
        'telefono.min' => 'El teléfono debe tener al menos 10 dígitos.',
        'telefono.max' => 'El teléfono no puede tener más de 15 dígitos.',
        'correo.required' => 'El correo es obligatorio.',
        'correo.email' => 'El correo debe ser válido.',
        'correo.regex' => 'El correo debe tener un formato válido con el símbolo @.',
        'ubicacion.required' => 'La ubicación es obligatoria.',
        'ubicacion.min' => 'La ubicación debe tener al menos 4 caracteres.',
        'estado.required' => 'Debe seleccionar el estado del proveedor.',
        'estado.in' => 'El estado debe ser 0 (inactivo) o 1 (activo).',
    ];

    public function submit()
    {
        // Valida los datos
        $this->validate();

        // Crea el proveedor
        Proveedor::create([
            'tipo_proveedor' => $this->tipo_proveedor,
            'nombre' => $this->nombre,
            'numero_documento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'ubicacion' => $this->ubicacion,
            'estado' => $this->estado,
        ]);

        // Redirige con un mensaje de éxito
        session()->flash('message', 'Proveedor creado exitosamente.');
        return redirect()->route('Admin.proveedores');
    }

    public function render()
    {
        return view('livewire.proveedor.create-proveedor');
    }
}
