<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria_insumo;
use App\Models\Categoria_Producto;
use App\Models\Insumo;
use App\Models\GenerarProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class GenerarProductoController extends Controller
{
    public function index(Request $request)
    {
        $categorias_insumos = Categoria_insumo::all();
        $insumosSeleccionados = session('insumosSeleccionados', []);

        // Si hay una categoría seleccionada, filtrar los insumos por esa categoría
        $categoriaId = $request->get('categoria_id');
        if ($categoriaId) {
            $insumosFiltrados = Insumo::where('id_categoria_insumo', $categoriaId)->get();
        } else {
            $insumosFiltrados = []; // No mostrar insumos hasta que se seleccione una categoría
        }

        return view('admin.generar_producto.index', compact('insumosFiltrados', 'categorias_insumos', 'insumosSeleccionados', 'categoriaId'));
    }


    public function filtrarInsumosPorCategoria(Request $request)
    {
        $categoriaId = $request->get('categoria_id');
        $categorias_insumos = Categoria_insumo::all();

        // Filtrar insumos basados en la categoría seleccionada
        $insumosFiltrados = Insumo::where('id_categoria_insumo', $categoriaId)->get();

        // Obtener los insumos seleccionados en la sesión
        $insumosSeleccionados = session('insumosSeleccionados', []);

        return view('admin.generar_producto.index', compact('insumosFiltrados', 'categorias_insumos', 'insumosSeleccionados', 'categoriaId'));
    }

    public function agregarInsumo(Request $request)
    {
        $request->validate([
            'insumo_id' => 'required|exists:insumos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Obtener insumos seleccionados de la sesión
        $insumosSeleccionados = session('insumosSeleccionados', []);

        // Comprobar si el insumo ya está en la sesión
        $existe = false;
        foreach ($insumosSeleccionados as &$insumo) {
            if ($insumo['id'] == $request->insumo_id) {
                // Si existe, incrementar la cantidad
                $insumo['cantidad'] += $request->cantidad;
                $existe = true;
                break;
            }
        }

        // Si no existe, agregar un nuevo insumo
        if (!$existe) {
            $insumosSeleccionados[] = [
                'id' => $request->insumo_id,
                'nombre' => Insumo::find($request->insumo_id)->nombre,
                'cantidad' => $request->cantidad,
            ];
        }

        // Guardar en la sesión
        session(['insumosSeleccionados' => $insumosSeleccionados]);

        // Redirigir manteniendo el ID de la categoría
        return redirect()->route('admin.generar_producto.index', ['categoria_id' => $request->get('categoria_id')])
            ->with('success', 'Insumo agregado correctamente.');
    }
    public function generarProducto(Request $request)
    {
        // Validar los datos del producto
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id', // Asegúrate de validar la categoría
            // Otras validaciones...
        ]);

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'id_categoria' => $request->categoria_id, // Asegúrate de que el campo sea correcto
            // Otros campos del producto...
        ]);
        // Obtener los insumos seleccionados de la sesión
        $insumosSeleccionados = session('insumosSeleccionados', []);

        // Guardar cada insumo utilizado en la tabla generar_productos
        foreach ($insumosSeleccionados as $insumo) {
            GenerarProducto::create([
                'id_producto' => $producto->id,
                'id_insumo' => $insumo['id'],
                'cantidad_utilizada' => $insumo['cantidad'],
            ]);

            // Descontar la cantidad de insumos del inventario
            $insumoModelo = Insumo::find($insumo['id']);
            $insumoModelo->cantidad -= $insumo['cantidad'];
            $insumoModelo->save();
        }

        // Limpiar la sesión después de generar el producto
        session()->forget('insumosSeleccionados');

        return redirect()->route('productos.index')->with('success', 'Producto generado exitosamente.');
    }

    public function eliminarInsumo($key)
    {
        // Lógica para eliminar un insumo seleccionado
        $insumos = session('insumosSeleccionados', []);
        unset($insumos[$key]);
        session(['insumosSeleccionados' => $insumos]);

        return redirect()->back()->with('success', 'Insumo eliminado correctamente.');
    }

    public function actualizarInsumo(Request $request, $key)
    {
        // Lógica para actualizar la cantidad de un insumo
        $insumos = session('insumosSeleccionados', []);
        if (isset($insumos[$key])) {
            if ($request->action === 'incrementar') {
                $insumos[$key]['cantidad']++;
            } elseif ($request->action === 'decrementar' && $insumos[$key]['cantidad'] > 1) {
                $insumos[$key]['cantidad']--;
            }
        }
        session(['insumosSeleccionados' => $insumos]);

        return redirect()->back()->with('success', 'Insumo actualizado correctamente.');
    }
}
