<?php

namespace App\Exports;

use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmpresasExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        $sheets = [];
        $empresas = CompanyReceivable::with('bills')->get();

        // Agregar hoja de "Resumen de Totales"
        $sheets[] = new ResumenTotalesExport();
        // $sheets[] = new publicasVencidasExport();
        // $sheets[] = new privadasvencidasExport();

        // $sheets[] = new privadasNoVenExport();
        // $sheets[] = new publicasNoVenExport();

        // //Mandar abajo el global y dar formato de pagina 
        // foreach ($empresas as $empresa) {
        //     $sheets[] = new EmpresaSheetExport($empresa);
        // }

        return $sheets;

    }   
}
