<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categoria_insumo;

class CategoriaInsumoTable extends Component
{
    use WithPagination;

    public $porPagina = 10;
    public $buscar = "";
    public $ordenarColumna = 'id';
    public $ordenarForma = 'asc';
    public $primeraCarga = true;

    protected $queryString = [
        'buscar' => ['except' => ''],
        'ordenarColumna' => ['except' => 'id'],
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

        $this->resetPage(); // Resetea la página al cambiar el orden
        $this->primeraCarga = false;
    }

    public function changeStatus($id)
    {
        $categoria_insumo = Categoria_insumo::find($id);
        $categoria_insumo->estado = !$categoria_insumo->estado;
        $categoria_insumo->save();
    }

    public function render()
    {
        return view('livewire.categoria_insumo-table', [
            'categoria_insumos' => Categoria_insumo::search($this->buscar)
                ->orderBy($this->ordenarColumna, $this->ordenarForma)
                ->paginate($this->porPagina)
        ]);
    }
}
