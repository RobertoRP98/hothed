<?php

namespace Database\Seeders;

use App\Models\Bill;
use Illuminate\Database\Seeder;
use App\Models\CompanyReceivable;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->actualizarStatusFacturas();
    }

//     public function actualizarStatusFacturas(){
//         Bill::whereNull('entry_date') // Selecciona facturas sin fecha de entrada
//         ->update(['status' => 'pendiente_entrada']); // Cambia el estado a "pendiente_entrada"
//     }

public function actualizarStatusFacturas()
{
    // Obtener la empresa con el nombre "GSM BRONCO"
    $company = CompanyReceivable::where('name', 'GSM BRONCO')->first();

    if ($company) {
        // Actualizar solo las facturas de esta empresa sin fecha de entrada
        Bill::where('companyreceivable_id', $company->id)
            ->whereNull('entry_date') // Selecciona facturas sin fecha de entrada
            ->update(['status' => 'pendiente_entrada']); // Cambia el estado a "pendiente_entrada"
    }
}


}
