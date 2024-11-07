<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CategoriaProducto;
use App\Models\Categoria_insumo;
use App\Models\Insumo;
use App\Models\InsumoProducto;
use App\Models\Producto;

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

    public $index_insumo_a_editar = null;
    public $categorias_productos;
    public $nombre;
    public $id_categoria_producto;
    public $descripcion;
    public $foto;
    public $precio;
    public $estado;
    public $producto;
    public $insumos;

    public function mount($id)
    {
        $this->categorias_insumos = Categoria_insumo::get();
        $this->categorias_productos = CategoriaProducto::get();
        $this->producto = Producto::find($id);
        $this->nombre = $this->producto->nombre;
        $this->id_categoria_producto = $this->producto->id_categoria_producto;
        $this->descripcion = $this->producto->descripcion;
        $this->precio = $this->producto->precio;
        $this->estado = $this->producto->estado;
        $this->insumos = $this->producto->insumos->toArray();
    }

    public function seleccionarInsumoParaEditar($index)
    {
        $this->index_insumo_a_editar = $index;
        $this->categoria_seleccionada = $this->insumos[$index]['id_categoria_insumo'];
        $this->insumo_seleccionado = $this->insumos[$index]['id'];
        $this->cantidad_usada = $this->insumos[$index]['pivot']['cantidad_usada'];

        $this->actualizarInsumosPorCategoria();
    }
    public function guardarCambiosInsumo($index)
{
    // Verificar que el índice a editar es válido
    if ($this->index_insumo_a_editar !== null && $this->index_insumo_a_editar === $index) {
        // Obtenemos el nuevo ID del insumo y la cantidad que se va a usar
        $id_insumo = $this->insumo_seleccionado;
        $cantidad_usada = $this->cantidad_usada;

        // Actualizamos el insumo en la tabla pivote
        $this->producto->insumos()->updateExistingPivot($this->insumos[$index]['id'], [
            'id_insumo' => $id_insumo,
            'cantidad_usada' => $cantidad_usada
        ]);

        $this->insumos = $this->producto->insumos->toArray();

        // Limpiamos la selección del índice de edición
        $this->index_insumo_a_editar = null;

        // Notificamos que se ha actualizado el insumo
        session()->flash('message', 'Insumo actualizado correctamente.');
    }
}



    public function actualizarInsumosPorCategoria()
    {
        $this->insumos_por_categoria = Insumo::where('id_categoria_insumo', $this->categoria_seleccionada)->get();
    }

    public function updateProducto()
    {
        $data = [
            "id_categoria_producto" => $this->id_categoria_producto,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "precio" => $this->precio,
            "estado" => $this->estado,
        ];

        if ($this->foto) {
            $data['foto'] = $this->foto->store('productos', 'public');
        }

        // Actualizamos el producto en la base de datos
        $this->producto->update($data);

        if ($this->index_insumo_a_editar !== null) {
            $id_insumo = $this->insumo_seleccionado;
            $cantidad = $this->cantidad_usada;

            $this->producto->insumos()->updateExistingPivot($this->insumos[$this->index_insumo_a_editar]['id'], [
                'id_insumo' => $id_insumo,
                'cantidad_usada' => $cantidad
            ]);
            
        }

        session()->flash('message', 'Producto actualizado correctamente');
        return redirect()->route('Admin.productos');
    }

    public function render()
    {
        return view('livewire.edit-producto', [
            'categorias_productos' => $this->categorias_productos,
            'insumos' => $this->insumos,
            'insumos_por_categoria' => $this->insumos_por_categoria,
        ]);
    }
}
