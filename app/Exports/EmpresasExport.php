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

        // Agregar hoja de "Resumen de Totales"
        $sheets[] = new ResumenTotalesExport();
        $sheets[] = new publicasVencidasExport();
        $sheets[] = new privadasvencidasExport();


        $sheets[] = new privadasNoVenExport();
        $sheets[] = new publicasNoVenExport();


        foreach ($empresas as $empresa) {
            $sheets[] = new EmpresaSheetExport($empresa);
        }

        return $sheets;


        // Supongamos que $sheet es tu hoja activa de trabajo
foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

    }


    
}
