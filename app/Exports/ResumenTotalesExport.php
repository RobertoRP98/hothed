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
    protected $totals;

    public function __construct($totals)
    {
        $this->totals = $totals;
    }

    public function array(): array
    {
        
    }

    public function title(): string
    {
        return 'Resumen de Totales';
    }
}
