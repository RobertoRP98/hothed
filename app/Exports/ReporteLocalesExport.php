<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ReporteLocalesExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets():array
    {
        $sheets = [];

        $sheets []= new ReporteLocalDebitoExport();

        $sheets []= new ReporteLocalCreditoExport();


        return $sheets;
    }
}
