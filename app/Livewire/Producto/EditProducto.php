<?php

namespace App\Livewire\Producto;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CategoriaProducto;
use App\Models\Categoria_insumo;
use App\Models\Insumo;
use App\Models\InsumoProducto;
use App\Models\Producto;
use Illuminate\Support\Facades\Http;


class EditProducto extends Component
{
    use WithFileUploads;

    public $insumos_agregados = [];
    public $insumos_por_categoria = [];
    public $insumo_seleccionado;
    public $categorias_insumos;
    public $categoria_seleccionada;
    public $cantidad_disponible;
    public $cantidad_usada;

    public $index_insumo_a_editar = null;
    public $categorias_productos;
    public $nombre;
    public $id_categoria_producto;
    public $descripcion;
    public $foto;
    public $precio;
    public $estado;
    public $producto;
    public $insumos;

    public function mount($id)
    {
        $this->categorias_insumos = Categoria_insumo::get();
        $this->categorias_productos = CategoriaProducto::get();
        $this->producto = Producto::find($id);
        $this->insumos = Insumo::find($id);
        $this->cantidad_disponible =  $this->insumos->cantidad_insumo;
        $this->nombre = $this->producto->nombre;
        $this->id_categoria_producto = $this->producto->id_categoria_producto;
        $this->foto = null;
        $this->descripcion = $this->producto->descripcion;
        $this->precio = $this->producto->precio;
        $this->estado = $this->producto->estado;
        $this->insumos = $this->producto->insumos->toArray();
    }

    public function seleccionarInsumoParaEditar($index)
    {
        $this->index_insumo_a_editar = $index;
        $this->categoria_seleccionada = $this->insumos[$index]['id_categoria_insumo'];
        $this->insumo_seleccionado = $this->insumos[$index]['id'];
        $this->cantidad_usada = $this->insumos[$index]['pivot']['cantidad_usada'];
        $this->actualizarInsumosPorCategoria();
    }
    public function guardarCambiosInsumo($index)
    {
        // Verificar que el índice a editar es válido
        if ($this->index_insumo_a_editar !== null && $this->index_insumo_a_editar === $index) {

            // Obtenemos el nuevo ID del insumo y la cantidad que se va a usar
            $id_insumo = $this->insumo_seleccionado;
            $cantidad_usada = $this->cantidad_usada;

            // Actualizamos el insumo en la tabla pivote
            $this->producto->insumos()->updateExistingPivot($this->insumos[$index]['id'], [
                'id_insumo' => $id_insumo,
                'cantidad_usada' => $cantidad_usada,
            ]);

            $this->insumos = $this->producto->insumos->toArray();

            // Limpiamos la selección del índice de edición
            $this->index_insumo_a_editar = null;

            // Notificamos que se ha actualizado el insumo
            session()->flash('message', 'Insumo actualizado correctamente.');
        }
    }



    public function actualizarInsumosPorCategoria()
    {
        $this->insumos_por_categoria = Insumo::where('id_categoria_insumo', $this->categoria_seleccionada)->get();
    }

    public function updateProducto()
    {
        // Validación: Foto es opcional durante la edición
        $rules = [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1000|max:12000000000',
            'estado' => 'required|boolean',
            'id_categoria_producto' => 'required|exists:categorias_productos,id_categoria_producto',
        ];

        // Si se selecciona una foto nueva, agregar la validación
        if ($this->foto) {
            $rules['foto'] = 'image|mimes:jpeg,png,jpg|max:2048'; // Validar foto si se selecciona una nueva
        }

        // Validamos los datos
        $this->validate($rules);

        $data = [
            "id_categoria_producto" => $this->id_categoria_producto,
            "nombre" => $this->nombre,
            "descripcion" => $this->descripcion,
            "precio" => $this->precio,
            "estado" => $this->estado,
        ];

        // Si se ha subido una nueva foto, sube la imagen y guarda la nueva URL
        if ($this->foto) {
            $filePath = $this->foto->getRealPath(); // Obtén la ruta temporal del archivo
            $imageData = base64_encode(file_get_contents($filePath)); // Codifica la imagen en base64

            // Realiza la solicitud a la API de Imgur
            $response = Http::withHeaders([
                'Authorization' => 'Client-ID b00a4e0e1ff8717',
            ])->post('https://api.imgur.com/3/image', [
                'image' => $imageData,
            ]);

            if ($response->successful()) {
                $data['foto'] = $response->json()['data']['link']; // Asigna la nueva URL de la foto
            } else {
                return redirect()->back()->withErrors('Error al subir la imagen a Imgur.');
            }
        } else {
            // Si no se subió una nueva foto, conserva la foto actual
            $data['foto'] = $this->producto->foto; // Asigna la foto actual si no se sube una nueva
        }

        // Actualizamos el producto en la base de datos
        $this->producto->update($data);

        // Actualizamos los insumos si es necesario
        if ($this->index_insumo_a_editar !== null) {
            $id_insumo = $this->insumo_seleccionado;
            $cantidad = $this->cantidad_usada;

            $this->producto->insumos()->updateExistingPivot($this->insumos[$this->index_insumo_a_editar]['id'], [
                'id_insumo' => $id_insumo,
                'cantidad_usada' => $cantidad
            ]);
        }

        session()->flash('message', 'Producto actualizado correctamente');
        return redirect()->route('Admin.productos');
    }


    public function render()
    {
        return view('livewire.producto.edit-producto', [
            'categorias_productos' => $this->categorias_productos,
            'insumos' => $this->insumos,
            'insumos_por_categoria' => $this->insumos_por_categoria,
            'cantidad_disponible' => $this->cantidad_disponible,
        ]);
    }
}
