<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Cart;



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

        Cart::add(
            $producto->id,
            $producto->nombre,
            1,
            $producto->precio,
            ["foto" => asset('storage/productos/' . $producto->foto)]
        );

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
}
