<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\CategoriaProducto;
use App\Models\Categoria_insumo;
use App\Models\InsumoProducto;
use App\Models\User;
use App\Models\Pqrs;
use App\Models\Pedido;
use App\Models\TipoFlor;
use App\Models\Flor;
use App\Models\Accesorio;
use App\Models\Comestible;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;




class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('vista_inicial','show','index','personalizados','agregar_producto','update_informacion','perfilUser','show','actualizar_producto','eliminar_producto');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function vista_inicial(Request $request)
    {
        $productos = Producto::where('estado', 1);

        if ($request->has('categoria_producto') && !empty($request->categoria_producto)) {
            $productos = $productos->whereIn('id_categoria_producto', $request->categoria_producto);
        }

        if ($request->has('search') && !empty($request->search)) {
            $productos = $productos->where('nombre', 'like', '%' . $request->search . '%');
        }

        $productos = $productos->get();
        $categoria_productos = CategoriaProducto::all();

        return view('landing', compact('productos', 'categoria_productos'));
    }

    public function index(Request $request)
    {
        // Iniciar consulta de productos activos
        $productos = Producto::query()->where('estado', 1);

        // Filtrar por categoría de producto
        if ($request->has('categoria_producto') && !empty($request->categoria_producto)) {
            $productos->whereIn('id_categoria_producto', $request->categoria_producto);
        }

        // Filtrar por búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $productos->where(function ($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->search . '%')
                      ->orWhereHas('insumos', function ($subQuery) use ($request) {
                          $subQuery->where('nombre', 'like', '%' . $request->search . '%');
                      });
            });
        }

        // Ordenar los productos según el criterio seleccionado
        if ($request->has('order_by') && !empty($request->order_by)) {
            switch ($request->order_by) {
                case 'mas_bajo':
                    $productos->orderBy('precio', 'asc');
                    break;
                case 'mas_caro':
                    $productos->orderBy('precio', 'desc');
                    break;
                case 'nuevos':
                    $productos->orderBy('created_at', 'desc');
                    break;
                case 'antiguos':
                    $productos->orderBy('created_at', 'asc');
                    break;
            }
        }

        // Obtener los productos filtrados
        $productos = $productos->get();

        // Obtener todas las categorías de productos
        $categoria_productos = CategoriaProducto::all();

        // Enviar a la vista
        return view('home', compact('productos', 'categoria_productos'));
    }
    

    public function update_informacion(Request $request)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();
    
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|min:3',
            'surname' => 'required|min:4',
            'celular' => 'required|min:6',
            'direccion' => 'required|min:4',
        ]);
    
        // Actualizar la información del usuario
        $usuario->name = $request->input('name');
        $usuario->surname = $request->input('surname');
        $usuario->celular = $request->input('celular');
        $usuario->direccion = $request->input('direccion');
        $usuario->save();
    
        // Redirecciona a la vista de perfil con un mensaje de éxito
        return redirect()->route('perfilUser', ['section' => 'edit-info'])->with('success', 'Usuario actualizado exitosamente');
    }
    
    

    public function perfilUser($section = 'edit-info')
    {
        $i = 0; 
        $user = Auth::user();
        $rol = $user->role->nombre;
        $pedidos = Pedido::where('user_id', $user->id)->get();
        $pqrs = Pqrs::all();
        $fecha = now()->format('Y-m-d');
        
        $activeSection = $section;
    
        return view('view_perfil.perfil', compact('user','fecha', 'rol', 'pqrs','section', 'pedidos', 'i', 'activeSection'));
    }
    

    public function show($id)
    {
        $productos = Producto::with('insumos')->findOrFail($id);
    
        return view('view_arreglo.arreglo_view', compact('productos'));
    }
    

    public function getInsumosPorCategoria($categoria_id)
    {
        $insumos = Insumo::where('id_categoria_insumo', $categoria_id)->get();

        if ($insumos->isEmpty()) {
            return response()->json([], 204); 
        }

        return response()->json($insumos);
    }

    public function personalizados(Request $request)
    {
        // Obtener todos los insumos disponibles
        $productos = Producto::all();
        $insumos = Insumo::all();
        $categorias_insumo = Categoria_insumo::all();

        // Recuperar los insumos seleccionados de la sesión
        $insumosSeleccionados = session()->get('insumosSeleccionados', []);

        // Inicializar los totales
        $totalElementos = 0;
        $totalPrecio = 0;

        // Arreglo para guardar los detalles de los insumos seleccionados
        $detallesInsumos = [];

        // Calcular el total de insumos seleccionados
        foreach ($insumosSeleccionados as $insumo) {
            $insumoBD = Insumo::find($insumo['id']);

            if ($insumoBD) {
                $totalElementos += $insumo['cantidad'];
                $totalPrecio += $insumoBD->costo_unitario * $insumo['cantidad'];

                // Guardar los detalles del insumo
                $detallesInsumos[] = [
                    'id' => $insumoBD->id,
                    'nombre' => $insumoBD->nombre, // Asumiendo que tienes un campo 'nombre'
                    'costo_unitario' => $insumoBD->costo_unitario,
                    'cantidad' => $insumo['cantidad'],
                ];
            }
        }

        // Agregar un valor adicional de 30,000 al total
        $totalPrecio += 30000;

        // Obtener el valor de 'section' de la solicitud (por defecto, se establece en '1')
        $section = $request->input('section', 0); // Usar 0 por defecto (paso 1)

        // Retornar la vista con los datos y el valor de section
        return view('view_arreglo.personalizado.personalizado', compact('insumos', 'categorias_insumo', 'insumosSeleccionados', 'totalElementos', 'totalPrecio', 'productos', 'detallesInsumos', 'section'));
    }
    
    

    public function agregar_producto(Request $request)
    {
        // Validar los campos recibidos del formulario
        $request->validate([
            'categoria_id' => 'required',
            'insumo_id' => 'required',
            'cantidad' => 'required|integer|min:1'
        ]);
    
        // Obtener el insumo seleccionado
        $insumo = Insumo::find($request->insumo_id);
    

        if ($insumo->cantidad_insumo < $request->cantidad) {
            return redirect()->back()->with('error', "Lamentamos informarte que solo hay {$insumo->cantidad_insumo} unidades disponibles de {$insumo->nombre}. No puedes agregar más.");
        }
    
        // Crear un nombre para el insumo que incluye el nombre y el color
        $nombre = $insumo->nombre . ' - ' . ($request->color ?? $insumo->color);
    
        // Obtener los insumos seleccionados de la sesión
        $insumosSeleccionados = session()->get('insumosSeleccionados', []);
    
        // Buscar si el insumo ya está en la lista
        $found = false;
        foreach ($insumosSeleccionados as &$insumoSeleccionado) {
            if ($insumoSeleccionado['id'] === $insumo->id && $insumoSeleccionado['color'] === $request->color) {
                // Si el insumo ya está, incrementa la cantidad con la nueva cantidad
                $nuevaCantidad = $insumoSeleccionado['cantidad'] + $request->cantidad;
    
                // Verifica que la nueva cantidad no exceda el inventario
                if ($nuevaCantidad > $insumo->cantidad_insumo) {
                    return redirect()->back()->withErrors("Lamentamos informarte que no puedes agregar más de {$insumo->cantidad_insumo} unidades de {$insumo->nombre}.");
                }
    
                // Si la cantidad es válida, actualiza la cantidad
                $insumoSeleccionado['cantidad'] = $nuevaCantidad;
                $found = true;
                break;
            }
        }
    
        // Si no se encontró el insumo, agregar uno nuevo
        if (!$found) {
            $insumosSeleccionados[] = [
                'id' => $insumo->id,
                'nombre' => $nombre,
                'color' => $request->color,
                'cantidad' => $request->cantidad,
                'precio' => $insumo->costo_unitario
            ];
        }
    
        // Guardar la lista de insumos seleccionados en la sesión
        session()->put('insumosSeleccionados', $insumosSeleccionados);
    
        session()->put('current_step', 1);
    
        // Redirigir de vuelta a la página con un mensaje de éxito
        return redirect()->route('personalizados')->with('success', 'Insumo agregado, verificar en paso 3.');
    }
    
    
    

    public function actualizar_producto(Request $request, $key)
    {
        // Obtener la acción (incrementar o decrementar)
        $action = $request->input('action');
        
        // Obtener la lista de insumos seleccionados de la sesión
        $insumos = session('insumosSeleccionados', []);
    
        // Verificar si el insumo existe en la lista
        if (isset($insumos[$key])) {
            if ($action == 'incrementar') {
                // Incrementar la cantidad del insumo
                $insumos[$key]['cantidad']++;
            } elseif ($action == 'decrementar') {
                // Decrementar la cantidad del insumo, asegurándose de que no baje de 1
                $insumos[$key]['cantidad'] = max(1, $insumos[$key]['cantidad'] - 1);
            }
            
            // Actualizar la lista de insumos en la sesión
            session(['insumosSeleccionados' => $insumos]);
        }

        session()->put('current_step', 2);
    
        // Redirigir de vuelta a la página
        return redirect()->back()->with('success', 'Insumo actualizado exitosamente.');
    }
    
    public function eliminar_producto($key)
    {
        // Obtener la lista de insumos seleccionados de la sesión
        $insumos = session('insumosSeleccionados', []);
    
        // Verificar si el insumo existe y eliminarlo
        if (isset($insumos[$key])) {
            unset($insumos[$key]);
        }
    
        // Actualizar la lista en la sesión
        session(['insumosSeleccionados' => $insumos]);

        session()->put('current_step', 2);
    
        // Redirigir de vuelta a la página con un mensaje de éxito
        return redirect()->back()->with('success', 'Insumo eliminado exitosamente.');
    }
    



    public function pqrs(Request $request)
    {
        $data = $request->validate([
            'fecha_envio' => 'required',
            'tipo' => 'required',
            'motivo' => 'required',
            'descripcion' => 'required',
        ]);

        try {
            $pqrs = new Pqrs();

            $pqrs->user_id = auth()->user()->id;
            $pqrs->fecha_envio = $data['fecha_envio'];
            $pqrs->tipo = $data['tipo'];
            $pqrs->motivo = $data['motivo'];
            $pqrs->descripcion = $data['descripcion'];
            $pqrs->save();

            Log::info('Resultado de la inserción: ' . ($pqrs ? 'Éxito' : 'Fallo'));

            if ($pqrs) {
                Log::info('Intentando redireccionar');
                return redirect()->route('perfilUser', ['section' => 'mispqrs'])->with('success', 'Pqrs enviada con éxito');
            } else {
                dd('Error al insertar en la base de datos');
            }
        } catch (\Exception $e) {
            Log::error('Error al insertar en la base de datos: ' . $e->getMessage());

            dd('Error al insertar en la base de datos: ' . $e->getMessage());
        }


        return redirect()->route('view_perfil.perfil')
            ->with('success', 'Pqrs creada con éxito.');
    }

    public function productos_filtrar()
    {
        $$productos = Producto::where('estado', 1)->get();
        $categoria_categoria = CategoriaProducto::where('estado',1)->get();

        return view('view_arreglo.all_products', compact('productos','categoria_categoria'));
    }
}
