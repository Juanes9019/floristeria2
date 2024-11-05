<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\DetalleCompraV2; // Asegúrate de que este sea el nombre correcto
use App\Models\Categoria_insumo;
use App\Models\Insumo;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Verificar si el permiso 'detalle' existe
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Compras')
                    ->first();
        
        // Si no se encuentra el permiso, retornar un error o mostrar la vista de acceso denegado
        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }
                    
        // Verificar si el usuario tiene el permiso asociado a su rol
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
        $compras = Compra::with('proveedor')->where('estado', 'Activa')->get(); // Asegúrate de obtener las compras y los proveedores

    
        return view('admin.compra.index', [
            'compras' => $compras,
            'i' => 1, // Empieza el índice desde 1 o el valor que prefieras
        ]);
    }
    

    public function create()
    {
        $user = auth()->user();

        // Verificar si el permiso 'detalle' existe
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Compras')
                    ->first();
        
        // Si no se encuentra el permiso, retornar un error o mostrar la vista de acceso denegado
        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }
                    
        // Verificar si el usuario tiene el permiso asociado a su rol
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }

        $categorias = Categoria_insumo::all();
        $insumos = Insumo::all();
        $proveedores = Proveedor::all(); // Aquí obtienes los proveedores
        
        return view('admin.compra.create', compact('categorias', 'insumos', 'proveedores'));
    }
    

    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'id_proveedor' => 'required',
                'carrito' => 'required',
                'costo_total' => 'required|numeric',
                'estado' => 'Activa',
            ]);
    
            // Crear la compra en la tabla 'compras'
            $compra = new Compra();
            $compra->id_proveedor = $request->input('id_proveedor');
            $compra->costo_total = $request->input('costo_total');
            $compra->save();

            
    
            // Procesar los ítems del carrito
            $carrito = json_decode($request->input('carrito'), true);
    
            foreach ($carrito as $item) {
                // Crear el detalle de compra
                $detalleCompra = DetalleCompraV2::create([
                    'compra_id' => $compra->id,
                    'id_categoria_insumo' => $item['id_categoria_insumo'] ?? null,
                    'id_insumo' => $item['id_insumo'] ?? null,
                    'cantidad' => $item['cantidad'] ?? 0,
                    'costo_unitario' => $item['costo_unitario'] ?? 0,
                    'subtotal' => $item['subtotal'] ?? 0,
                    'total' => $item['total'] ?? 0,
                ]);

                  // Actualizar la cantidad del insumo en la tabla 'insumos'
                $insumo = Insumo::find($item['id_insumo']);
                if ($insumo) {
                    // Aumentar la cantidad del insumo en base a la cantidad comprada
                    $insumo->cantidad_insumo += $item['cantidad'];
                    $insumo->save();
                }
            }
    
            // Redirigir al index de compras
            return redirect()->route('Admin.compra.index')->with('success', 'Compra registrada exitosamente');
            
        } catch (\Exception $e) {
            // En caso de error, regresar con un mensaje de error
            return redirect()->back()->with('error', 'Hubo un error al procesar la compra: ' . $e->getMessage());
        }
    }
    



    public function show($id)
    {
        $user = auth()->user();

        // Verificar si el permiso 'detalle' existe
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Compras')
                    ->first();
        
        // Si no se encuentra el permiso, retornar un error o mostrar la vista de acceso denegado
        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }
                    
        // Verificar si el usuario tiene el permiso asociado a su rol
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
        $compra = Compra::with('detalles.insumo')->findOrFail($id);
        $i = 0; 
        return view('Admin.compra.show', compact('compra', 'i'));
    }

    public function getCategorias($idProveedor)
    {
        // Obtén las categorías de insumos asociadas al proveedor dado
        $categorias = Categoria_insumo::where('id_proveedor', $idProveedor)->get();

        // Devuelve las categorías en formato JSON
        return response()->json($categorias);
    }

    // Método para obtener insumos asociados a una categoría
    public function getInsumos($idCategoria)
    {
        // Obtén los insumos asociados a la categoría dada
        $insumos = Insumo::where('id_categoria_insumo', $idCategoria)->get();

        // Devuelve los insumos en formato JSON
        return response()->json($insumos);
    }

    public function destroy($id)
{
    try {
        // Verificar si la compra existe
        $compra = Compra::findOrFail($id);

        // Verificar si tiene detalles y eliminarlos
        $detalles = DetalleCompraV2::where('compra_id', $id)->get();
        
        foreach ($detalles as $detalle) {
            $insumo = Insumo::find($detalle->id_insumo);
            if ($insumo) {
                if ($insumo->cantidad_insumo < $detalle->cantidad) {
                    return redirect()->back()->with('error', 'No se puede anular la compra porque ya se ha utilizado parte de los insumos.');
                }
            }
        }

        // Restaurar la cantidad de insumos
        foreach ($detalles as $detalle) {
            $insumo = Insumo::find($detalle->id_insumo);
            if ($insumo) {
                $insumo->cantidad_insumo -= $detalle->cantidad;
                $insumo->save();
            }
        }

        // Cambiar el estado de la compra a 'inactiva'
        $compra->estado = 'Anulada';
        $compra->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('Admin.compra.index')->with('success', 'Compra anulada exitosamente');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Hubo un error al anular la compra: ' . $e->getMessage());
    }
}




}
