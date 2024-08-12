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

use Illuminate\Support\Facades\Http;


use App\Mail\EnviarCorreo;
use Illuminate\Support\Facades\Mail;

// En tu controlador
use Barryvdh\DomPDF\Facade\Pdf;

//importar request para las validaciones
use App\Http\Requests\CarritoRequest;




class carritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        // Realizar la solicitud a la API de Overpass
        $response = Http::get('https://overpass-api.de/api/interpreter', [
            'data' => '[out:json];(node["place"="city"]["name"~"^(Medellín|Bello|Envigado|Itagüí|Sabaneta|La Estrella|Caldas|Copacabana|Girardota|Barbosa)$"];way["place"="city"]["name"~"^(Medellín|Bello|Envigado|Itagüí|Sabaneta|La Estrella|Caldas|Copacabana|Girardota|Barbosa)$"];relation["place"="city"]["name"~"^(Medellín|Bello|Envigado|Itagüí|Sabaneta|La Estrella|Caldas|Copacabana|Girardota|Barbosa)$"];);out body;>;out skel qt;'
        ]);
    
        $data = $response->json();
    
        // Extraer nombres de las ciudades
        $cities = collect($data['elements'])
            ->filter(fn($item) => isset($item['tags']['name']))
            ->pluck('tags.name');
    
        // Retornar a la vista carrito.cart con las ciudades
        return view('carrito.cart', compact('cities'));
    }
    

    public function add(Request $request)
    {

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
        
        return redirect()->back()->with("success", "Arreglo floral agregado correctamente al carrito");
    }

    public function removeItem(Request $request)
    {

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
        $pedido->estado      = "Nuevo";
        $pedido->user_id     = auth()->user()->id; // Asignar el user_id antes de guardar
        $pedido->save();
    
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
                $detalle->subtotal     = $item->price * $item->qty;
                
                $producto = Producto::find($item->id);
                $detalle->imagen = $producto->foto;
                
                $detalle->save();
    
                $inventario->cantidad -= $item->qty;
                $inventario->save();
            }
        }
    
        // Limpiar el carrito después de procesar el pedido
        Cart::destroy();

        $pdf = Pdf::loadView('pdf.pdf', ['pedido' => $pedido]);

        Mail::to(auth()->user()->email)->send(new EnviarCorreo($pedido, $pdf->output()));
    
        return redirect()->back()->with("success", "Arreglo adquirido con éxito, pedido en camino");
    }
    

        public function pdf(){
            $pdf = Pdf::loadView('pdf.pdf');
        
            return $pdf->stream();
        }

    
}
