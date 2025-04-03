<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteExtranjerasExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        
        $sheets [] = new ReporteExtranjeraDebitoExport();

        $sheets [] = new ReporteExtranjeraCreditoExport();

        return $sheets;
    }
    
}
