<?php

namespace App\Livewire\Proveedor;

use App\Models\Proveedor;
use Livewire\Component;
use Illuminate\Support\Facades\Http;



class CreateProveedor extends Component
{
    public $tipo_proveedor = 'empresa'; // Valor predeterminado

    public function mount()
    {
        // Si existe un valor previo para 'tipo', se usará, de lo contrario, 'empresa' será el valor por defecto
        $this->tipo_proveedor = old('tipo', 'empresa');
    }

    // Este método se ejecuta al cambiar el valor de tipo_proveedor
    public function updatedTipoProveedor($value)
    {
        $this->tipo_proveedor = $value;
    }

    public function render()
    {
        return view('livewire.proveedor.create-proveedor');
    }
}
