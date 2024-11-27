<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\DetalleCompraV2;
use App\Models\Categoria_insumo;
use App\Models\Insumo;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CompraExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;


class CompraController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Compras')
                    ->first();
        
        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
        // $compras = Compra::with('proveedor')->where('estado', 'Activa')->get(); // Asegúrate de obtener las compras y los proveedores

    
        return view('admin.compra.index');
    }
    

    public function create()
    {
        $user = auth()->user();

        $permiso = DB::table('permisos')
                    ->where('nombre', 'Compras')
                    ->first();
        
        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }

        $categorias = Categoria_insumo::all();
        $insumos = Insumo::all();
        $proveedores = Proveedor::all(); 
        
        return view('admin.compra.create', compact('categorias', 'insumos', 'proveedores'));
    }
    

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_proveedor' => 'required',
                'carrito' => 'required',
                'costo_total' => 'required|numeric',
                'estado' => 'Activa',
            ]);
    
            $compra = new Compra();
            $compra->id_proveedor = $request->input('id_proveedor');
            $compra->costo_total = $request->input('costo_total');
            $compra->save();

            $carrito = json_decode($request->input('carrito'), true);
            foreach ($carrito as $item) {
                $detalleCompra = DetalleCompraV2::create([
                    'compra_id' => $compra->id, 
                    'id_categoria_insumo' => $item['id_categoria_insumo'] ?? null,
                    'id_insumo' => $item['id_insumo'] ?? null,
                    'cantidad' => $item['cantidad'] ?? 0,
                    'costo_unitario' => $item['costo_unitario'] ?? 0,
                    'subtotal' => $item['subtotal'] ?? 0,
                    'total' => $item['total'] ?? 0,
                ]);

                $insumo = Insumo::find($item['id_insumo']);
                if ($insumo) {
                    $insumo->cantidad_insumo += $item['cantidad'];
                    $insumo->save();
                }
            }
    
            return redirect()->route('Admin.compra.index')->with('success', 'Compra registrada exitosamente');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al procesar la compra: ' . $e->getMessage());
        }
    }
    



    public function show($id)
    {
        $user = auth()->user();

        $permiso = DB::table('permisos')
                    ->where('nombre', 'Compras')
                    ->first();
        
        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }
                    
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
        $categorias = Categoria_insumo::where('id_proveedor', $idProveedor)->get();

        return response()->json($categorias);
    }

    public function getInsumos($idCategoria)
    {
        $insumos = Insumo::where('id_categoria_insumo', $idCategoria)->get();

        return response()->json($insumos);
    }

    public function destroy($id)
{
    try {
        $compra = Compra::findOrFail($id);

        $detalles = DetalleCompraV2::where('compra_id', $id)->get();
        
        foreach ($detalles as $detalle) {
            $insumo = Insumo::find($detalle->id_insumo);
            if ($insumo) {
                if ($insumo->cantidad_insumo < $detalle->cantidad) {
                    return redirect()->back()->with('error', 'No se puede anular la compra porque ya se ha utilizado parte de los insumos.');
                }
            }
        }

        foreach ($detalles as $detalle) {
            $insumo = Insumo::find($detalle->id_insumo);
            if ($insumo) {
                $insumo->cantidad_insumo -= $detalle->cantidad;
                $insumo->save();
            }
        }

        $compra->estado = 'Anulada';
        $compra->save();

        return redirect()->route('Admin.compra.index')->with('success', 'Compra anulada exitosamente');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Hubo un error al anular la compra: ' . $e->getMessage());
    }
}

public function export($format)
    {
        $export = new CompraExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.compras', [
                    'compras' => Compra::all()
                ])->setPaper('a4', 'portait') // Puedes cambiar a 'portrait' si prefieres
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('Compras.pdf');
            case 'xlsx':
            default:
                return $export->download('Compras.xlsx', Excel::XLSX);
        }
    }


    //Flutter

    public function getCompra()
    {
        $compras = Compra::all();
        return response()->json($compras);
    }

    public function unaCompra($id){
        $compras = Compra::findOrFail($id);
        return response()->json($compras);
    }

    public function detalle_flutter($id)
    {
        $compras = Compra::with('detalles.insumo')->findOrFail($id);
        return response()->json($compras);
    }

    public function storeFromMobile(Request $request)
    {
        try {
            // Validar los datos recibidos
            $this->validateRequest($request);

            // Crear la compra
            $compra = $this->createCompra($request);

            // Guardar los detalles de la compra y actualizar el inventario
            $this->processCompraDetails($compra, $request->input('detalles'));

            // Responder con éxito
            return response()->json(['message' => 'Compra registrada exitosamente'], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => 'Hubo un error al procesar la compra: ' . $e->getMessage()], 500);
        }
    }

    // Validar los datos de la solicitud
    private function validateRequest($request)
    {
        $request->validate([
            'id_proveedor' => 'required',
            'detalles' => 'required|array',
            'costo_total' => 'required|numeric',
            'estado' => 'required|string',
        ]);
    }

    // Crear la compra
    private function createCompra($request)
    {
        $compra = new Compra();
        $compra->id_proveedor = $request->input('id_proveedor');
        $compra->costo_total = $request->input('costo_total');
        $compra->estado = $request->input('estado');
        $compra->save();

        return $compra;
    }

    // Procesar los detalles de la compra y actualizar el inventario
    private function processCompraDetails($compra, $detalles)
    {
        foreach ($detalles as $item) {
            // Crear el detalle de compra
            $detalleCompra = DetalleCompraV2::create([
                'compra_id' => $compra->id,
                'id_categoria_insumo' => $item['id_categoria_insumo'],
                'id_insumo' => $item['id_insumo'],
                'cantidad' => $item['cantidad'],
                'costo_unitario' => $item['costo_unitario'],
                'subtotal' => $item['subtotal'],
                'total' => $item['total'],
            ]);

            // Actualizar el inventario de insumos
            $this->updateInsumoInventory($item['id_insumo'], $item['cantidad']);
        }
    }

    // Actualizar el inventario de insumos
    private function updateInsumoInventory($insumoId, $cantidad)
    {
        $insumo = Insumo::find($insumoId);
        if ($insumo) {
            $insumo->cantidad_insumo += $cantidad;
            $insumo->save();
        }
    }
}
