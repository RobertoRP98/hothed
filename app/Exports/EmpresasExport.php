<?php

namespace App\Exports;

use App\Models\CompanyReceivable;
use App\Exports\EmpresaSheetExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromCollection;

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
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CompanyReceivable::all();
    }
}
