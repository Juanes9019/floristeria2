<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(Categoria_Producto_Seeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(Categoria_insumoSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(InventarioSeeder::class);
    }
}
