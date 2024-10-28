<?php

namespace App\Livewire;

use App\Models\Categoria_insumo;
use App\Models\CategoriaProducto;
use App\Models\Insumo;
use App\Models\InsumoProducto;
use App\Models\Producto;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;

class InsumoProductoTable extends Component
{
    use WithFileUploads;
    public $insumos_agregados = [];
    public $insumos_por_categoria = [];
    public $insumo_seleccionado;
    public $categorias_insumos;
    public $categoria_seleccionada;
    public $cantidad_disponible;
    public $cantidad_usada;
    public $productoComponent;


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
        $this->estado = 0;
        $this->insumos_agregados = session()->get('insumos_agregados', []);
        $this->categorias_insumos = Categoria_insumo::all();
        $this->categorias_producto = CategoriaProducto::all();
    }
    public function updatedCategoriaSeleccionada()
    {
        if ($this->categoria_seleccionada) {
            $this->insumos_por_categoria = Insumo::where('id_categoria_insumo', $this->categoria_seleccionada)->get();
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
        if ($this->insumo_seleccionado && $this->cantidad_usada > 0) {
            $insumo = Insumo::find($this->insumo_seleccionado);
            if ($insumo && $this->cantidad_usada <= $this->cantidad_disponible) {
                $this->insumos_agregados[] = [
                    'id' => $insumo->id,
                    'nombre' => $insumo->nombre,
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
        // $this->validate([
        //     'nombre' => 'required|string|unique:productos,nombre',
        //     'descripcion' => 'required|string',
        //     'precio' => 'required|numeric|min:0',
        // 'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        //     'estado' => 'required',
        //     'id_categoria_producto' => 'required|exists:categorias_productos,id_categoria_producto'
        // ]);


        // Procesar la imagen
        if ($this->foto) {
            $filePath = $this->foto->getRealPath(); // Obtén la ruta temporal del archivo
            $imageData = base64_encode(file_get_contents($filePath)); // Codifica en base64
        } else {
            return redirect()->back()->withErrors('No se ha cargado ninguna imagen.');
        }

        // Realiza la solicitud a la API de Imgur
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID b00a4e0e1ff8717',
        ])->post('https://api.imgur.com/3/image', [
            'image' => $imageData,
        ]);

        // Crear y guardar el producto
        $newProducto = new Producto();
        $newProducto->id_categoria_producto = $this->id_categoria_producto;
        $newProducto->nombre = $this->nombre;
        $newProducto->descripcion = $this->descripcion;
        $newProducto->precio = $this->precio;
        $newProducto->estado = $this->estado;

        if ($response->successful()) {
            $newProducto->foto = $response->json()['data']['link'];
        } else {
            dd($response->body()); // Imprime la respuesta para depurar el error
            return redirect()->back()->withErrors('Error al subir la imagen a Imgur.');
        }


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
        return view('livewire.insumo-producto-table', [
            'categorias_productos' => $this->categorias_producto
        ]);
    }
}
