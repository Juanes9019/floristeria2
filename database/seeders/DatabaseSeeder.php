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
        $this->call(UserSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(Sub_categoriaSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(InventarioSeeder::class);
    }
}
