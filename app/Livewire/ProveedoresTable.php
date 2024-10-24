<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Proveedor;

class ProveedoresTable extends Component
{
    use WithPagination;

    public $porPagina = 10;
    public $buscar = "";
    public $ordenarColumna = 'id';
    public $ordenarForma = 'asc';
    public $primeraCarga = true;
    public $modal= false;

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

        $this->resetPage(); 
        $this->primeraCarga = false;
    }

    public function changeStatus($id)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->estado = !$proveedor->estado;
        $proveedor->save();
    }

    public function render()
    {
        return view('livewire.proveedores-table', [
            'proveedores' => Proveedor::search($this->buscar)
                ->orderBy($this->ordenarColumna, $this->ordenarForma)
                ->paginate($this->porPagina)
        ]);
    }

    public function openmodal(){
        $this-> modal=true;
    }
    
    public function closemodal(){
        $this -> modal = false;
    }
}
