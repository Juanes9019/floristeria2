<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Compra;

class CompraTable extends Component
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

        $this->resetPage();
        $this->primeraCarga = false;
    }

    public function anularCompra($compraId)
    {
        $compra = Compra::find($compraId);

        if ($compra && $compra->estado !== 'Anulada') {
            $compra->estado = 'Anulada';
            $compra->save();

            // Emitimos un evento para actualizar la interfaz sin recargar la página
            $this->emit('compraAnulada', $compraId);
        }
    }

    public function render()
    {
        $compras = Compra::search($this->buscar)
            ->orderBy($this->ordenarColumna, $this->ordenarForma)
            ->paginate($this->porPagina);

        return view('livewire.compra-table', compact('compras'));
    }
}
