<?php

namespace Database\Seeders;

use App\Models\Bill;
use Illuminate\Database\Seeder;
use App\Models\CompanyReceivable;

class TomsPorcent extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->aplicarDescuentoPublicaToms854();
    }

    public function aplicarDescuentoPublicaToms854()
    {
        // Obtener la empresa "Publica Toms 854"
        $company = CompanyReceivable::where('name', 'PEMEX TOMS 854')
                    ->where('type', 'Pemex')
                    ->first();

        if ($company) {
            // Seleccionar facturas de "Publica Toms 854" donde porcent == true
            $bills = Bill::where('companyreceivable_id', $company->id)
                        ->where('porcent', true)
                        ->get();

            // Aplicar el 20% en total_payment a cada factura seleccionada
            foreach ($bills as $bill) {
                $bill->total_payment = $bill->total_payment * 0.2;
                $bill->save();
            }
        }
    }
}
