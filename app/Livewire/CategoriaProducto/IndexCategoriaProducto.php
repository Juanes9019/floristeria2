<?php

namespace App\Livewire\CategoriaProducto;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CategoriaProducto;

class IndexCategoriaProducto extends Component
{
    use WithPagination;

    public $porPagina = 10;
    public $buscar = "";
    public $ordenarColumna = 'id_categoria_producto';
    public $ordenarForma = 'asc';
    public $primeraCarga = true;

    protected $queryString = [
        'buscar' => ['except' => ''],
        'ordenarColumna' => ['except' => 'id_categoria_producto'],
        'ordenarForma' => ['except' => 'asc'],
        'page' => ['except' => 1]
    ];

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function sortBy($columna)
    {
        if ($this->ordenarColumna == $columna) {
            $this->ordenarForma = $this->ordenarForma === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarColumna = $columna;
            $this->ordenarForma = 'asc';
        }

        $this->resetPage(); 
        $this->primeraCarga = false;
    }

    public function changeStatus($id)
    {
        $proveedor = CategoriaProducto::find($id);
        $proveedor->estado = !$proveedor->estado;
        $proveedor->save();
    }

    public function render()
    {
        return view('livewire.categoria_producto.index-categoria-producto', [
            'categorias_productos' => CategoriaProducto::search($this->buscar)
                ->orderBy($this->ordenarColumna, $this->ordenarForma)
                ->paginate($this->porPagina)
        ]);
    }
}
