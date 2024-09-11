<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Categoria_Producto;
use App\Models\User;
use App\Models\Pedido;
use App\Models\TipoFlor;
use App\Models\Flor;
use App\Models\Accesorio;
use App\Models\Comestible;
use Illuminate\Support\Facades\DB;
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
        $this->middleware('auth')->except('vista_inicial','show','index','personalizados');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function vista_inicial()
    {
        $productos = Producto::all();
        return view('home', compact('productos'));
    }


    public function index()
    {
        $productos = Producto::all();

        return view('home', compact('productos'));
    }

    public function dashboard()
    {
        return view('Admin.dashboard');
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
        
        $activeSection = $section;
    
        return view('view_perfil.perfil', compact('user', 'rol', 'section', 'pedidos', 'i', 'activeSection'));
    }
    

    public function show($id)
    {
        $productos = Producto::findOrFail($id);

        return view('view_arreglo.arreglo_view', compact('productos'));
    }


    public function show_all(Request $request)
{
    $categoria_categoria = Categoria_Producto::all();

    $filtro = Producto::query();

    if ($request->has('categoria') && $request->input('filtro') !== 'todos') {
        $categoria_id = $request->get('categoria');
        $filtro->where('id_categoria', $categoria_id);
    }

    if ($request->has('query')) {
        $consulta = $request->get('query');
        $filtro->where(function($q) use ($consulta) {
            $q->where('nombre', 'like', '%' . $consulta . '%');
        });
    }

    if ($request->has('filtro') && $request->get('filtro') !== 'todos') {
        switch ($request->get('filtro')) {
            case 'caro':
                $filtro->orderBy('precio', 'desc');
                break;
            case 'barato':
                $filtro->orderBy('precio', 'asc');
                break;
            case 'nuevos':
                $filtro->orderBy('created_at', 'desc');
                break;
            case 'antiguos':
                $filtro->orderBy('created_at', 'asc');
                break;
        }
    }

    $productos = $filtro->get();

    return view('view_arreglo.all_products', compact('productos', 'categoria_categoria'));
}

public function personalizados(Request $request)
{
    $flores = Flor::all();
    $accesorios = Accesorio::all();
    $comestibles = Comestible::all();

    // Recuperar los seleccionados de la sesión
    $floresSeleccionadas = session()->get('floresSeleccionadas', []);
    $accesoriosSeleccionados = session()->get('accesoriosSeleccionados', []);
    $comestiblesSeleccionados = session()->get('comestiblesSeleccionados', []);

    // Inicializar totales
    $totalElementos = 0;
    $totalPrecio = 0;

    // Calcular total de flores
    foreach ($floresSeleccionadas as $flor) {
        $totalElementos += $flor['cantidad'];
        $totalPrecio += $flor['precio'] * $flor['cantidad'];
    }

    // Calcular total de accesorios
    foreach ($accesoriosSeleccionados as $accesorio) {
        $totalElementos += $accesorio['cantidad'];
        $totalPrecio += $accesorio['precio'] * $accesorio['cantidad'];
    }

    // Calcular total de comestibles
    foreach ($comestiblesSeleccionados as $comestible) {
        $totalElementos += $comestible['cantidad'];
        $totalPrecio += $comestible['precio'] * $comestible['cantidad'];
    }

    // Retornar la vista con totales
    return view('view_arreglo.personalizado', compact('flores', 'accesorios', 'comestibles', 'floresSeleccionadas', 'accesoriosSeleccionados', 'comestiblesSeleccionados', 'totalElementos', 'totalPrecio'));
}


public function agregarFlor(Request $request)
{
    $request->validate([
        'flor_id' => 'required',
        'color' => 'required',
        'cantidad' => 'required|integer|min:1'
    ]);

    $flor = Flor::find($request->flor_id);
    $nombre = $flor->nombre . ' - ' . $request->color; 

    $floresSeleccionadas = session()->get('floresSeleccionadas', []);
    $found = false;
    foreach ($floresSeleccionadas as &$florSeleccionada) {
        if ($florSeleccionada['nombre'] === $nombre) {
            // Si ya existe, sumar la cantidad
            $florSeleccionada['cantidad'] += $request->cantidad;
            $found = true;
            break;
        }
    }

    // Si no se encontró, agregar una nueva entrada
    if (!$found) {
        $floresSeleccionadas[] = [
            'nombre' => $nombre,
            'color' => $request->color,  // Asegúrate de que el color también se guarde en la sesión
            'cantidad' => $request->cantidad,
            'precio' => $flor->precio
        ];
    }

    session()->put('floresSeleccionadas', $floresSeleccionadas);
    return redirect()->route('personalizados')->with('success', 'Flor agregada exitosamente.');
}


public function actualizarFlor(Request $request, $key)
{
    $action = $request->input('action');
    $flores = session('floresSeleccionadas', []);

    if (isset($flores[$key])) {
        if ($action == 'incrementar') {
            $flores[$key]['cantidad']++;
        } elseif ($action == 'decrementar') {
            $flores[$key]['cantidad'] = max(1, $flores[$key]['cantidad'] - 1);
        }
        session(['floresSeleccionadas' => $flores]);
    }

    return redirect()->back();
}

public function eliminarFlor($key)
{
    $flores = session('floresSeleccionadas', []);
    unset($flores[$key]);
    session(['floresSeleccionadas' => $flores]);

    return redirect()->back();
}


public function agregarAccesorio(Request $request)
{
    $request->validate([
        'accesorio_id' => 'required',
        'cantidad' => 'required|integer|min:1'
    ]);

    $accesorio = Accesorio::find($request->accesorio_id);

    $accesoriosSeleccionados = session()->get('accesoriosSeleccionados', []);
    $accesoriosSeleccionados[] = [
        'nombre' => $accesorio->nombre,
        'cantidad' => $request->cantidad,
        'precio' => $accesorio->precio
    ];

    session()->put('accesoriosSeleccionados', $accesoriosSeleccionados);
    return redirect()->route('personalizados')->with('success', 'Accesorio agregado exitosamente.');
}


public function actualizarAccesorio(Request $request, $key)
{
    $action = $request->input('action');
    $accesorio = session('accesorioSeleccionadas', []);

    if (isset($accesorio[$key])) {
        if ($action == 'incrementar') {
            $accesorio[$key]['cantidad']++;
        } elseif ($action == 'decrementar') {
            $accesorio[$key]['cantidad'] = max(1, $accesorio[$key]['cantidad'] - 1);
        }
        session(['accesorioSeleccionadas' => $accesorio]);
    }

    return redirect()->back();
}

public function eliminarAccesorio($key)
{
    $accesorio = session('accesorioSeleccionadas', []);
    unset($flores[$key]);
    session(['accesorioSeleccionadas' => $accesorio]);

    return redirect()->back();
}

public function agregarComestible(Request $request)
{
    $request->validate([
        'comestible_id' => 'required',
        'cantidad' => 'required|integer|min:1'
    ]);

    $comestible = Comestible::find($request->comestible_id);

    $comestiblesSeleccionados = session()->get('comestiblesSeleccionados', []);
    $comestiblesSeleccionados[] = [
        'nombre' => $comestible->nombre,
        'cantidad' => $request->cantidad,
        'precio' => $comestible->precio
    ];

    session()->put('comestiblesSeleccionados', $comestiblesSeleccionados);
    return redirect()->route('personalizados')->with('success', 'Comestible agregado exitosamente.');
}

public function actualizarComestible(Request $request, $key)
{
    $action = $request->input('action');
    $comestible = session('comestibleSeleccionadas', []);

    if (isset($comestible[$key])) {
        if ($action == 'incrementar') {
            $comestible[$key]['cantidad']++;
        } elseif ($action == 'decrementar') {
            $comestible[$key]['cantidad'] = max(1, $comestible[$key]['cantidad'] - 1);
        }
        session(['comestibleSeleccionadas' => $comestible]);
    }

    return redirect()->back();
}

public function eliminarComestible($key)
{
    $comestible = session('comestibleSeleccionadas', []);
    unset($flores[$key]);
    session(['comestibleSeleccionadas' => $comestible]);

    return redirect()->back();
}




    public function productos_filtrar()
    {
        $productos = Producto::all();
        $categoria_categoria = Categoria_Producto::all();

        return view('view_arreglo.all_products', compact('productos','categoria_categoria'));
    }
}
