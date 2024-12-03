<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;

class ProductoModal extends Component
{


    public $productoId;  // ID del producto para obtener los detalles
    public $producto;    // Datos del producto
    public $showModal = false;  // Controla la visibilidad del modal

    protected $listeners = ['loadProducto' => 'loadProducto'];  // Escuchar el evento

    // Cargar los detalles del producto cuando se setea el productoId
    public function loadProducto($id)
    {
        $this->producto = Producto::with('categoria_producto', 'insumos')->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.producto-modal');
    }
}
