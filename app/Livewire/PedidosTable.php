<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pedido;
use App\Models\Insumo;
use App\Models\Producto;
use App\Mail\PedidoCambiado;
use App\Notifications\EstadoPedido;
use Illuminate\Support\Facades\Mail;

class PedidosTable extends Component
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

    public function changeStatus($id, $action)
    {
        $pedido = Pedido::findOrFail($id);

        if ($action === 'reject') {
            $pedido->estado = 'rechazado';
        } elseif ($action === 'accept') {
            if ($pedido->estado === 'no recibido') {
                if ($pedido->user) {
                    $pedido->user->notify(new EstadoPedido($pedido));
                    Mail::to($pedido->user->email)->send(new PedidoCambiado($pedido));
                }

                $pedido->estado = 'en camino';
            } else {
                switch ($pedido->estado) {
                    case 'nuevo':
                        $pedido->estado = 'preparacion';
                        foreach ($pedido->detalles as $detalle) {
                            if (is_null($detalle->id_producto)) {
                                $items = json_decode($detalle->opciones, true)['items'];
                                foreach ($items as $item) {
                                    $insumo = Insumo::where('nombre', $item['name'])->where('color', $item['color'])->first();
                                    if ($insumo) {
                                        $insumo->cantidad_insumo -= $item['qty'];
                                        $insumo->save();
                                    }
                                }
                            } else {
                                $producto = Producto::find($detalle->id_producto);
                                if ($producto) {
                                    foreach ($producto->insumos as $insumo) {
                                        $cantidadUsada = $insumo->pivot->cantidad_usada;
                                        $insumo->cantidad_insumo -= $cantidadUsada * $detalle->cantidad;
                                        $insumo->save();
                                    }
                                }
                            }
                        }
                        break;

                    case 'preparacion':
                        $pedido->estado = 'en camino';
                        break;

                    case 'en camino':
                        $pedido->estado = 'entregado';
                        break;
                }
            }
        }

        $pedido->save();

        if ($pedido->estado !== 'no recibido' && $pedido->user) {
            // Solo enviar la notificación y el correo si el estado no es "no recibido"
            $pedido->user->notify(new EstadoPedido($pedido));
            Mail::to($pedido->user->email)->send(new PedidoCambiado($pedido));
        }

        session()->flash('success', 'El estado del pedido ha sido actualizado con éxito');
    }
    
    

    public function render()
    {
        $pedidos = Pedido::search($this->buscar)
            ->orderBy($this->ordenarColumna, $this->ordenarForma)
            ->paginate($this->porPagina);
            
    
        return view('livewire.pedidos-table', compact('pedidos'));
    }
    

    public function openmodal(){
        $this-> modal=true;
    }
    
    public function closemodal(){
        $this -> modal = false;
    }
}
