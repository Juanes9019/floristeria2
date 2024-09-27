<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\PedidoNotificacion;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\User;
use App\Models\DatosEnvio;
use App\Models\Detalle;
use App\Models\Inventario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Cart;


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
        $this->middleware('auth')->except('add','index');
    }

    public function index()
    {
        $filePath = public_path('js/cities.json');

        if (!file_exists($filePath)) {
            // Manejo del error si el archivo no se encuentra
            abort(404, 'El archivo de ciudades no se encuentra.');
        }

        $cities = json_decode(file_get_contents($filePath), true);

        $cities = collect($cities)->sort()->values();

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

    public function add_personalizado()
    {
        $floresSeleccionadas = session()->get('floresSeleccionadas', []);
        $accesoriosSeleccionados = session()->get('accesoriosSeleccionados', []);
        $comestiblesSeleccionados = session()->get('comestiblesSeleccionados', []);

        $totalPrecio = 0;
        $nombreArreglo = 'Arreglo Personalizado';

        $items = [];

        foreach ($floresSeleccionadas as $flor) {
            $totalPrecio += $flor['precio'] * $flor['cantidad'];
            $items[] = [
                'id' => null, 
                'name' => $flor['nombre'],
                'qty' => $flor['cantidad'],
                'price' => $flor['precio']
            ];
        }

        foreach ($accesoriosSeleccionados as $accesorio) {
            $totalPrecio += $accesorio['precio'] * $accesorio['cantidad'];
            $items[] = [
                'id' => null, 
                'name' => $accesorio['nombre'],
                'qty' => $accesorio['cantidad'],
                'price' => $accesorio['precio']
            ];
        }

        foreach ($comestiblesSeleccionados as $comestible) {
            $totalPrecio += $comestible['precio'] * $comestible['cantidad'];
            $items[] = [
                'id' => null, 
                'name' => $comestible['nombre'],
                'qty' => $comestible['cantidad'],
                'price' => $comestible['precio']
            ];
        }

        Cart::add([
            'id' => 'arreglo-personalizado',
            'name' => $nombreArreglo,
            'qty' => 1, 
            'price' => $totalPrecio,
            'options' => [
                'items' => $items
            ]
        ]);

        session()->forget('floresSeleccionadas');
        session()->forget('accesoriosSeleccionados');
        session()->forget('comestiblesSeleccionados');

        return redirect()->route('personalizados')->with('success', 'Arreglo personalizado agregado al carrito exitosamente.');
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
    

    public function confirmarCarrito(Request $request)
    {
        $request->validate([
            'nombre_destinatario' => 'required|string|max:255',
            'fecha' => 'required|date',
            'departamento' => 'required|string',
            'ciudad' => 'required|string',
            'direccion' => 'required|string|max:255',
            'instrucciones_entrega' => 'nullable|string|max:500',
            'telefono' => 'required|string|max:20',
            'comprobante_pago' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $file = $request->file('comprobante_pago'); // obtiene el archivo subido en el campo
    
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID b00a4e0e1ff8717',
        ])->post('https://api.imgur.com/3/image', [
            'image' => base64_encode(file_get_contents($file)), // convierte el contenido en base64 en el cuerpo
        ]);
    
        if ($response->successful()) {
            $imgurUrl = $response->json()['data']['link']; // obtiene la URL de la respuesta exitosa
    
            $pedido = new Pedido();
            $pedido->total = Cart::total();
            $pedido->fechapedido = now();
            $pedido->estado = "Nuevo";
            $pedido->user_id = auth()->user()->id;
            $pedido->comprobante_url = $imgurUrl;
            $pedido->save();
    
            $administradores = User::whereHas('role', function($query) {
                $query->where('nombre', 'Admin');
            })->get();
    
            foreach ($administradores as $admin) {
                $admin->notify(new PedidoNotificacion($pedido));
            }
    
            try {
                foreach (Cart::content() as $item) {
                    if ($item->id === 'arreglo-personalizado') {

                        $detalle = new Detalle();
                        $detalle->id_pedido = $pedido->id;
                        $detalle->id_producto = null; 
                        $detalle->precio = $item->price;
                        $detalle->cantidad = $item->qty;
                        $detalle->subtotal = $item->price * $item->qty;
                        $detalle->opciones = json_encode($item->options);
                        $detalle->imagen = null; 
                        $detalle->save();
                    } else {
                        // Producto estándar
                        $producto= Producto::where('id_producto', $item->id)->first();
    
                        if (!$producto) {
                            throw new \Exception('Inventario no encontrado para el producto: ' . $item->id);
                        }
    
                        if ($producto->cantidad < $item->qty) {
                            throw new \Exception("Lamentamos informarte que la cantidad que deseas no se encuentra disponible en este momento. Cantidad disponible: $producto->cantidad");
                        } else {
                            $detalle = new Detalle();
                            $detalle->id_pedido = $pedido->id;
                            $detalle->id_producto = $item->id;
                            $detalle->precio = $item->price;
                            $detalle->cantidad = $item->qty;
                            $detalle->subtotal = $item->price * $item->qty;
    
                            $producto = Producto::find($item->id);
                            $detalle->imagen = $producto ? $producto->foto : null;
    
                            $detalle->save();
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error al guardar los detalles del pedido: ' . $e->getMessage() . ' en el archivo: ' . $e->getFile() . ' en la línea: ' . $e->getLine());
                \Log::info('Contenido del carrito: ', Cart::content()->toArray());
                return response()->view('errors.error', ['error' => 'Error al procesar el pedido. Por favor, inténtalo nuevamente.']);
            }
    
            Cart::destroy();

            $datosEnvio = $request->only([
                'nombre_destinatario', 
                'fecha', 
                'departamento', 
                'ciudad', 
                'direccion', 
                'instrucciones_entrega', 
                'telefono'
            ]);

            // Generar el PDF con los datos del pedido y del envío
            $pdf = Pdf::loadView('pdf.pdf', [
                'pedido' => $pedido,
                'datosEnvio' => $datosEnvio,
            ]);

            // Enviar el correo con el PDF adjunto
            Mail::to(auth()->user()->email)->send(new EnviarCorreo($pedido, $pdf->output()));
    
            return redirect()->back()->with("success", "Arreglo adquirido con éxito, pedido en camino");
        } else {
            \Log::error('Error al subir la imagen a Imgur: ' . $response->body());
            return back()->withErrors(['comprobante_pago' => 'Error al subir la imagen a Imgur. Por favor, inténtalo nuevamente.']);
        }
    }
}
