<?php

namespace App\Livewire\Producto;

use App\Models\Categoria_insumo;
use App\Models\CategoriaProducto;
use App\Models\Insumo;
use App\Models\Producto;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

class CreateProducto extends Component
{
    use WithFileUploads;
    public $insumos_agregados = [];
    public $insumos_por_categoria = [];
    public $insumo_seleccionado;
    public $categorias_insumos;
    public $categoria_seleccionada;
    public $cantidad_disponible;
    public $cantidad_usada;


    public $productos = [];
    public $nombre;
    public $id_categoria_producto;
    public $descripcion;
    public $foto;
    public $precio;
    public $estado;
    public $categorias_producto = [];



    public function mount()
    {

        $this->insumos_agregados = session()->get('insumos_agregados', []);
        $this->categorias_insumos = Categoria_insumo::all();
        $this->categorias_producto = CategoriaProducto::all();
        $this->estado = 0;
    }
    public function updatedCategoriaSeleccionada()
    {
        // if ($this->categoria_seleccionada) {
        //     $this->insumos_por_categoria = Insumo::where('id_categoria_insumo', $this->categoria_seleccionada)->get();
        // }
        if ($this->categoria_seleccionada) {
            $this->insumos_por_categoria = Insumo::where('id_categoria_insumo', $this->categoria_seleccionada)
                ->where('cantidad_insumo', '>', 0)
                ->get();
        }
    }


    public function updatedInsumoSeleccionado()
    {
        $insumo = Insumo::find($this->insumo_seleccionado);
        if ($insumo) {
            $this->cantidad_disponible = $insumo->cantidad_insumo;
        }
    }



    public function agregarInsumo()
    {
        $this->validate([
            'categoria_seleccionada' => 'required|exists:categoria_insumos,id',
            'insumo_seleccionado' => 'required|exists:insumos,id',
            'cantidad_usada' => 'required|numeric|min:1|max:12000000000'
        ]);

        if ($this->insumo_seleccionado && $this->cantidad_usada > 0) {
            $insumo = Insumo::find($this->insumo_seleccionado);
            if ($insumo && $this->cantidad_usada <= $this->cantidad_disponible) {
                $this->insumos_agregados[] = [
                    'id' => $insumo->id,
                    'nombre' => $insumo->nombre,
                    'color' => $insumo->color,
                    'cantidad' => $this->cantidad_usada,
                    'cantidad_disponible' => $insumo->cantidad_insumo
                ];
                $this->updateSession();
                $this->clearFields();
            }
        }
    }

    public function incrementarInsumo($index)
    {
        if (isset($this->insumos_agregados[$index]) && $this->insumos_agregados[$index]['cantidad'] < $this->insumos_agregados[$index]['cantidad_disponible']) {
            $this->insumos_agregados[$index]['cantidad'] += 1;
            $this->updateSession();
        }
    }

    public function decrementarInsumo($index)
    {
        if (isset($this->insumos_agregados[$index]) && $this->insumos_agregados[$index]['cantidad'] > 1) {
            $this->insumos_agregados[$index]['cantidad'] -= 1;
            $this->updateSession();
        } else {
            $this->eliminarInsumo($index);
        }
    }

    public function eliminarInsumo($index)
    {
        if (isset($this->insumos_agregados[$index])) {
            unset($this->insumos_agregados[$index]);
            $this->insumos_agregados = array_values($this->insumos_agregados);
            $this->updateSession();
        }
    }

    public function updateSession()
    {
        session()->put('insumos_agregados', $this->insumos_agregados);
    }

    public function clearFields()
    {
        $this->categoria_seleccionada = [];
        $this->insumo_seleccionado = [];
        $this->cantidad_disponible = '';
        $this->cantidad_usada = '';
    }

    public function crearProducto()
    {
        $this->validate([
            'nombre' => 'required|string|unique:productos,nombre',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1000|max:12000000000',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'estado' => 'required|boolean',
            'id_categoria_producto' => 'required|exists:categorias_productos,id_categoria_producto'
        ]);

        // Establecer el valor de inactivo en caso de que sea nulo
        if ($this->estado == null) {
            $this->estado = 0;
        }

        // Procesar la imagen
        if ($this->foto) {
            $filePath = $this->foto->getRealPath(); // Obtén la ruta temporal del archivo
            $imageName = time() . '.' . $this->foto->getClientOriginalExtension(); // Generar nombre único para la imagen

            // Intentar almacenar la imagen localmente
            $localImagePath = storage_path('app/public/productos/' . $imageName); // Ruta donde se almacenará la imagen
            $this->foto->storeAs('public/productos', $imageName); // Almacenar imagen localmente
        } else {
            return redirect()->back()->withErrors('No se ha cargado ninguna imagen.');
        }

        // Variable para la URL de la imagen
        $imageUrl = null;

        // Intentar hasta 3 veces subir la imagen a Imgur
        $retries = 3;
        $attempt = 0;
        $success = false;
        while ($attempt < $retries && !$success) {
            try {
                // Realiza la solicitud a la API de Imgur
                $response = Http::withHeaders([
                    'Authorization' => 'Client-ID b00a4e0e1ff8717',
                ])->post('https://api.imgur.com/3/image', [
                    'image' => base64_encode(file_get_contents($filePath)),
                ]);

                if ($response->successful()) {
                    // Si la API de Imgur responde exitosamente, obtener la URL de la imagen
                    $imageUrl = $response->json()['data']['link'];
                    $success = true; // Se marca como exitoso
                } else {
                    // Si la API no responde correctamente, lanzamos una excepción para que se intente de nuevo
                    throw new \Exception('Error al intentar subir la imagen a Imgur');
                }
            } catch (\Exception $e) {
                // Si ocurre un error, incrementamos el contador de intentos
                $attempt++;
                if ($attempt >= $retries) {
                    // Si se alcanzaron los intentos máximos, se sale del bucle y usa la imagen local
                    $imageUrl = asset('storage/productos/' . $imageName); // Ruta local de la imagen
                    $success = true; // Terminamos el proceso con la imagen local
                }
            }
        }

        // Crear y guardar el producto
        $newProducto = new Producto();
        $newProducto->id_categoria_producto = $this->id_categoria_producto;
        $newProducto->nombre = $this->nombre;
        $newProducto->descripcion = $this->descripcion;
        $newProducto->precio = $this->precio;
        $newProducto->estado = $this->estado;

        // Asignar la URL de la imagen (local o de Imgur)
        $newProducto->foto = $imageUrl;

        $newProducto->save(); // Guardar el producto antes de asociar insumos

        // Manejar insumos seleccionados
        foreach ($this->insumos_agregados as $insumoAgregado) {
            $insumoModel = Insumo::find($insumoAgregado['id']);
            if ($insumoModel) {
                $newProducto->insumos()->attach($insumoModel->id, ['cantidad_usada' => $insumoAgregado['cantidad']]);
            }
        }


        // Limpiar la sesión y redirigir
        session()->forget('insumos_agregados');
        session()->flash('success', 'Producto creado exitosamente');
        return redirect()->route('Admin.productos');
    }


    public function render()
    {
        return view('livewire.producto.create-producto', [
            'categorias_productos' => $this->categorias_producto
        ]);
    }
}
