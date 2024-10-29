<?php

namespace App\Exports;

use App\Models\Bill;
use App\Models\Currency;
use App\Http\Controllers\BillController;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ResumenTotalesExport implements FromArray, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $dollarRate = Currency::where('currency', 'USD')->latest()->value('rate');

        // Totalizando por tipo de empresa y estado
        $totals = [
            ['Tipo de Empresa', 'Estado', 'Total en MXN'],
            ['Privada', 'Pendiente de Facturar', BillController::class,'totalPrivadasPendienteFacturar'],
            ['Privada', 'Vencidas', BillController::class,'totalPrivadasVencidas'],
            ['Privada', 'No Vencidas', BillController::class,'totalPrivadasNoVencidas'],
           
        ];

        return $totals;
    }

    public function title(): string
    {
        return 'Resumen de Totales';
    }
}
