<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Detalle;
use App\Models\Inventario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Cart;
use Illuminate\Support\Facades\Storage;

// En tu controlador
use Barryvdh\DomPDF\Facade\Pdf;



class carritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Configurar impuestos
    public function configureTax()
    {
        Cart::tax(19, '.', ',');
        Cart::addCost('Costo adicional', 7000);
    }

    public function index()
    {
        return view('carrito.cart');
    }

    public function add(Request $request)
    {
        // Llamar al método de configuración de impuestos
        $this->configureTax();

        $producto= Producto::find($request->id);
        if(empty($producto))
            return redirect('/');

        Cart::add([
            'id' => $producto->id,
            'name' => $producto->nombre,
            'qty' => 1,
            'price' => $producto->precio,
            'options' => [
                'image' => $producto->foto,
            ]
        ]);
        Cart::addCost('Costo de envío', 7000);

        return redirect()->back()->with("success", "Arreglo floral agregado correctamente al carrito");
    }

    public function removeItem(Request $request)
    {
        // Llamar al método de configuración de impuestos
        $this->configureTax();

        Cart::remove($request->rowId);

        return redirect()->back()->with("success", "Arreglo floral eliminado correctamente del carrito");
    }

    public function clear()
    {
        Cart::destroy();

        return redirect()->back()->with("success", "carrito vacido");
    }


    public function incrementar(Request $request)
    {
        $producto = Cart::content()->where("rowId", $request->id)->first();
        Cart::update($request->id, ["qty" => $producto->qty + 1]);
    
        return back()->with("success", "¡Agregaste una unidad más!");
    }
    
    public function decrementar(Request $request)
    {
        $producto = Cart::content()->where("rowId", $request->id)->first();
        Cart::update($request->id, ["qty" => $producto->qty - 1]);
    
        return back()->with("success", "¡Quitaste una unidad más!");
    }
    
    

    public function confirmarCarrito(){
        // Crear un pedido para el carrito
        $pedido = new Pedido();
        $pedido->total       = Cart::total();
        $pedido->fechapedido = now();
        $pedido->procedencia = "Web";
        $pedido->estado      = "Nuevo";
        $pedido->user_id     = auth()->user()->id; // Asignar el user_id antes de guardar
        $pedido->save();
    
        // Iterar sobre los productos en el carrito y crear los detalles del pedido
        foreach(Cart::content() as $item){
            // Restar del inventario
            $inventario = Inventario::where('id_producto', $item->id)->first();
    
            if ($inventario->cantidad < $item->qty) {
                return back()->withErrors(["status" => "Lamentamos informarte que la cantidad que deseas no se encuentra disponible en este momento. Cantidad disponible: $inventario->cantidad"]);
            } else {
                $detalle = new Detalle();
                $detalle->id_pedido   = $pedido->id;
                $detalle->id_producto = $item->id;
                $detalle->precio      = $item->price;
                $detalle->cantidad    = $item->qty;
                $detalle->importe     = $item->price * $item->qty;
                $detalle->subtotal    = $item->subtotal; 
                $detalle->impuesto    = $item->tax;
                
                $producto = Producto::find($item->id);
                $detalle->imagen = $producto->foto;
                
                $detalle->save();
    
                $inventario->cantidad -= $item->qty;
                $inventario->save();
            }
        }
    
        // Limpiar el carrito después de procesar el pedido
        Cart::destroy();
    
        return redirect()->back()->with("success", "Arreglo adquirido con éxito, pedido en camino");
    }
    

    public function pdf(){
        $pdf = Pdf::loadView('pdf.pdf');
    
        return $pdf->stream();
    }
    
}
