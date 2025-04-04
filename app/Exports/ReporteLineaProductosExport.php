<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteLineaProductosExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        //Obtener las lineas de producto
        $lines = Supplier::distinct()->pluck('product_type');

        foreach ($lines as $line){
            $sheets[] = new SupplierLineExport($line); // Se pasa la linea a cada hoja
        }

        return $sheets;
    }
}
