<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CategoriaProducto;
use App\Models\Categoria_insumo;
use App\Models\Insumo;
use App\Models\InsumoProducto;
use App\Models\Producto;
use Illuminate\Support\Facades\Http;


class EditProducto extends Component
{
    use WithFileUploads;
    public $insumos_agregados = [];
    public $insumos_por_categoria = [];
    public $insumo_seleccionado;
    public $categorias_insumos;
    public $categoria_seleccionada;
    public $cantidad_disponible;
    public $cantidad_usada;
    public $productoComponent;

    public $categorias_productos;
    public $nombre;
    public $id_categoria_producto;
    public $descripcion;
    public $foto;
    public $precio;
    public $estado;
    public $producto;


    public function mount($id){
        $this->categorias_productos = CategoriaProducto::get();
        $this->producto = Producto::find($id);
        $this->nombre = $this->producto->nombre;
        $this->id_categoria_producto = $this->producto->id_categoria_producto;
        $this->descripcion = $this->producto->descripcion;
        $this->precio = $this->producto->precio;
        $this->estado = $this->producto->estado;
    }

    public function updateProducto(){
        $data = [
            "id_categoria_producto" => $this->id_categoria_producto,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "precio" => $this->precio,
            "estado" => $this->estado,
        ];

        // Verificar si se ha cargado una nueva foto
        if ($this->foto) {
            $data['foto'] = $this->foto->store('productos', 'public');
        }

        $this->producto->update($data);
        session()->flash('message', 'Producto actualizado correctamente');
        return redirect()->route('Admin.productos');
    }

    public function render(){
        return view('livewire.edit-producto',[
            'categorias_productos' => $this->categorias_productos
        ]);
    }
    
}
