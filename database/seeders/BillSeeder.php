<?php

namespace Database\Seeders;

use App\Models\Bill;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->actualizarStatusFacturas();
    }

    public function actualizarStatusFacturas(){
        Bill::whereNull('entry_date') // Selecciona facturas sin fecha de entrada
        ->update(['status' => 'pendiente_entrada']); // Cambia el estado a "pendiente_entrada"
    }
}
