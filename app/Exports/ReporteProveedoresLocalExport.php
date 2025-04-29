<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteProveedoresLocalExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function sheets(): array
   {
    $sheets = [];

    $sheets [] = new ProveedorConcluidoSinPagoLocalExport();
    $sheets [] = new ProveedorNoPagadaLocalExport();
    $sheets [] = new ProveedorPagadaLocalExport();


   return $sheets;
   }

}
