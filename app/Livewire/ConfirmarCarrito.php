<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmarCarrito extends Component
{
    public $nombre_destinatario;
    public $fecha;
    public $direccion;
    public $instrucciones_entrega;
    public $telefono;

    protected $rules = [
        'nombre_destinatario' => 'required|string|regex:/^[a-zA-Z\s]+$/',
        'direccion' => 'required|string|min:10',
        'instrucciones_entrega' => 'required|string|min:10',
        'telefono' => 'required|numeric|digits:10',
    ];

    protected $messages = [
        'nombre_destinatario.required' => 'Por favor, completa el nombre del destinatario.',
        'nombre_destinatario.regex' => 'Por favor, ingresa un nombre de destinatario válido.',
        'direccion.required' => 'Por favor, completa la dirección.',
        'direccion.min' => 'Ingresa una dirección válida de al menos 10 caracteres.',
        'instrucciones_entrega.required' => 'Por favor, completa las instrucciones de entrega.',
        'instrucciones_entrega.min' => 'Ingresa instrucciones válidas de al menos 10 caracteres.',
        'telefono.required' => 'Por favor, completa el teléfono.',
        'telefono.numeric' => 'Por favor, ingrese datos numericos.',
        'telefono.digits' => 'Por favor, ingrese 10 digitos exactos.',
    ];

    public function mount()
    {
        $this->fecha = now()->format('Y-m-d');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        // Aquí puedes manejar el formulario, por ejemplo, guardarlo en la base de datos.

        session()->flash('message', 'Detalles de envío guardados con éxito.');
    }

    public function render()
    {
        return view('livewire.confirmar-carrito');
    }
}
?>