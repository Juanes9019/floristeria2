<?php

namespace App\Livewire;

use App\Models\CategoriaProducto;
use Livewire\Component;

class Producto extends Component
{
    public $productos = [];
    public $nombre;
    public $categoriaProductos;
    public $descripcion;
    public $foto;
    public $precio;
    public $estado;



    public function createProducto(){
        $newProducto = new Producto();
        $newProducto->nombre = $this->nombre;
        $newProducto->categoriaProductos = $this->categoriaProductos;
        $newProducto->descripcion = $this->descripcion;
        $newProducto->precio = $this->precio;
        $newProducto->foto = $this->foto;
        $newProducto->estado = $this->estado;
        $newProducto->save();
    }

    public function clearFields(){
        $this->nombre = '';
        $this->categoriaProductos = '';
        $this->descripcion = '';
        $this->precio = '';
        $this->foto = '';
        $this->estado = '';
    }


    public function render()
    {
        return view('livewire.producto');
    }

}
