<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pedido;

class PedidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pedido::create([
            'user_id' => 1,
            'total' => 320000,
            'fechapedido' => now(),
            'estado' => 'nuevo',
            'comprobante_url' => 'https://i.imgur.com/akP7rYh.jpeg', 
            'datos_envio' => json_encode([
                'nombre_destinatario' => 'Carlos López',
                'fecha' => '2024-11-16',
                'departamento' => 'Antioquia',
                'ciudad' => 'Medellín',
                'direccion' => 'Calle 456 a #21-123',
                'instrucciones_entrega' => 'Por favor entregar en recepción',
                'telefono' => '3001234568',
            ]),
            'datos_rechazo' => null, 
        ]);

        Pedido::create([
            'user_id' => 2, 
            'total' => 250000,
            'fechapedido' => now(),
            'estado' => 'preparacion',
            'comprobante_url' => 'https://i.imgur.com/akP7rYh.jpeg', 
            'datos_envio' => json_encode([
                'nombre_destinatario' => 'Ana Torres',
                'fecha' => '2024-11-17',
                'departamento' => 'Antioquia',
                'ciudad' => 'Envigado', 
                'direccion' => 'Calle 789 #41-2',
                'instrucciones_entrega' => 'Entregar en portería, edificio azul',
                'telefono' => '3001234569',
            ]),
            'datos_rechazo' => null,
        ]);
    }
}
