<?php

namespace App\Livewire;

use App\Models\Categoria_insumo;
use App\Models\Insumo;
use App\Models\InsumoProducto;
use Livewire\Component;

class InsumoProductoTable extends Component
{
    public $insumos_agregados = [];
    public $insumos_por_categoria = [];
    public $insumo_seleccionado;
    public $categorias;
    public $categoria_seleccionada;
    public $cantidad_disponible;
    public $cantidad_usada;



    public function mount()
    {
        $this->insumos_agregados = session()->get('insumos_agregados', []);
        $this->categorias = Categoria_insumo::all();
    }
    public function updatedCategoriaSeleccionada()
    {
        if ($this->categoria_seleccionada) {
            $this->insumos_por_categoria = Insumo::where('id_categoria_insumo', $this->categoria_seleccionada)->get();
        }
    }

    public function updatedInsumoSeleccionado()
    {
        $insumo = Insumo::find($this->insumo_seleccionado);
        if ($insumo) {
            $this->cantidad_disponible = $insumo->cantidad_insumo;
        }
    }



    public function agregarInsumo()
    {
        if ($this->insumo_seleccionado && $this->cantidad_usada > 0) {
            $insumo = Insumo::find($this->insumo_seleccionado);
            if ($insumo && $this->cantidad_usada <= $this->cantidad_disponible) {
                $this->insumos_agregados[] = [
                    'id' => $insumo->id, 
                    'nombre' => $insumo->nombre,
                    'cantidad' => $this->cantidad_usada,
                    'cantidad_disponible' => $insumo->cantidad_insumo
                ];
                $this->updateSession();
                $this->clearFields();
            }
        }
    }

    public function incrementarInsumo($index)
    {
        if (isset($this->insumos_agregados[$index]) && $this->insumos_agregados[$index]['cantidad'] < $this->insumos_agregados[$index]['cantidad_disponible']) {
            $this->insumos_agregados[$index]['cantidad'] += 1;
            $this->updateSession();
        }
    }

    public function decrementarInsumo($index)
    {
        if (isset($this->insumos_agregados[$index]) && $this->insumos_agregados[$index]['cantidad'] > 1) {
            $this->insumos_agregados[$index]['cantidad'] -= 1;
            $this->updateSession();
        } else {
            $this->eliminarInsumo($index);
        }
    }

    public function eliminarInsumo($index)
    {
        if (isset($this->insumos_agregados[$index])) {
            unset($this->insumos_agregados[$index]);
            $this->insumos_agregados = array_values($this->insumos_agregados);
            $this->updateSession();
        }
    }

    public function updateSession()
    {
        session()->put('insumos_agregados', $this->insumos_agregados);
    }

    public function clearFields()
    {
        $this->categoria_seleccionada = [];
        $this->insumo_seleccionado = [];
        $this->cantidad_disponible = '';
        $this->cantidad_usada = '';
    }

    public function crearProducto()
    {
        // Guardar insumos en la sesión
        session()->put('insumos_agregados', $this->insumos_agregados);

        // Redirigir a la nueva vista para ingresar más detalles del producto
        return redirect()->route('Admin.producto.create');
    }




    public function render()
    {
        return view('livewire.insumo-producto-table');
    }
}
