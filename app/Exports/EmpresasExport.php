<?php

namespace App\Exports;

use App\Models\CompanyReceivable;
use App\Exports\EmpresaSheetExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmpresasExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $sheets = [];
        $empresas = CompanyReceivable::with('bills')->get();

        foreach ($empresas as $empresa) {
            $sheets[] = new EmpresaSheetExport($empresa);
        }

         // Agregar hoja de "Resumen de Totales"
         $sheets[] = new ResumenTotalesExport();

        return $sheets;
    }
    
}
