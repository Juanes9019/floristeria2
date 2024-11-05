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
use App\Models\Insumo;
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
        $this->middleware('auth')->except('add','index', 'incrementar', 'removeItem', 'decrementar', 'clear');
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
    // Recuperar los insumos seleccionados de la sesión
    $insumosSeleccionados = session()->get('insumosSeleccionados', []);
    
    $totalPrecio = 0;
    $nombreArreglo = 'Arreglo Personalizado';
    $items = [];

    // Calcular el total y preparar los items para el carrito
    foreach ($insumosSeleccionados as $insumo) {
        $insumoBD = Insumo::find($insumo['id']);
        
        if ($insumoBD) {
            $totalPrecio += $insumoBD->costo_unitario * $insumo['cantidad'];
            $items[] = [
                'id' => null, 
                'name' => $insumoBD->nombre,
                'qty' => $insumo['cantidad'],
                'price' => $insumoBD->costo_unitario,
                'color' => $insumoBD->color // Agregar el color aquí
            ];
        }
    }

    // Agregar un valor adicional de 30,000 al total
    $totalPrecio += 30000;

    // Agregar el arreglo personalizado al carrito
    Cart::add([
        'id' => 'arreglo-personalizado',
        'name' => $nombreArreglo,
        'qty' => 1, 
        'price' => $totalPrecio,
        'options' => [
            'items' => $items
        ]
    ]);

    // Limpiar la sesión de insumos seleccionados
    session()->forget('insumosSeleccionados');

    return redirect()->route('personalizados')->with('success', 'Arreglo personalizado agregado al carrito exitosamente.');
}


    public function removeItem(Request $request)
    {
        $rowId = $request->input('rowId');
    
        if (Cart::get($rowId)) {
            Cart::remove($rowId);
            return redirect()->back()->with('success', 'Producto eliminado del carrito.');
        } else {
            return redirect()->back()->withErrors(['status' => 'No se pudo eliminar el producto.']);
        }
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
        'nombre_destinatario' => 'required|string|max:80',
        'fecha' => 'required|date',
        'departamento' => 'required|string',
        'ciudad' => 'required|string',
        'direccion' => 'required|string|max:150|regex:/^[0-9a-zA-Z\s.,#-]+$/',
        'instrucciones_entrega' => 'nullable|string|max:200',
        'telefono' => 'required|string|max:15', 
        'comprobante_pago' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    ]);

    $file = $request->file('comprobante_pago'); // obtiene el archivo subido en el campo

    $response = Http::withHeaders([
        'Authorization' => 'Client-ID b00a4e0e1ff8717',
    ])->post('https://api.imgur.com/3/image', [
        'image' => base64_encode(file_get_contents($file)), // convierte el contenido en base64
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
                    // Lógica para arreglos personalizados
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
                    $producto = Producto::where('id', $item->id)->first();

                    if (!$producto) {
                        throw new \Exception('Inventario no encontrado para el producto: ' . $item->id);
                    }

                    // Log para verificar la cantidad
                    \Log::info("Verificando producto: {$producto->id}, cantidad solicitada: {$item->qty}, cantidad disponible: {$producto->cantidad}");

                    if ($producto->cantidad < $item->qty) {
                        throw new \Exception("Lamentamos informarte que la cantidad que deseas no se encuentra disponible en este momento. Cantidad disponible: $producto->cantidad");
                    } else {
                        $detalle = new Detalle();
                        $detalle->id_pedido = $pedido->id;
                        $detalle->id_producto = $item->id;
                        $detalle->precio = $item->price;
                        $detalle->cantidad = $item->qty;
                        $detalle->subtotal = $item->price * $item->qty;

                        // Actualiza la imagen del producto
                        $detalle->imagen = $producto->foto ?? null;

                        // Guarda el detalle del pedido
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
