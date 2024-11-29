<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\CompanyReceivable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class pendienteFacturarEmpresa implements
 FromArray,
 WithHeadings,
 WithTitle,
WithColumnFormatting,
ShouldAutoSize,
WithEvents
{

    use RegistersEventListeners;

    protected $empresa;

    //propiedad estetica temporal para almacenar la empresa
    protected static $tempEmpresa;

    public function __construct(CompanyReceivable $empresa)
    {
     $this->empresa = $empresa;
    // self::$tempEmpresa = $empresa; //almacenar temporalmente   
    }
   
    public function array(): array
    {
        // Obtener las facturas con el estado "pendiente_facturar" para esta empresa
        $pendienteFacturar = Bill::where('companyreceivable_id', $this->empresa->id) 
        ->where('status', 'pendiente_facturar') // Solo facturas pendientes
        ->get();

        if ($pendienteFacturar->isEmpty()) {
            return [['Sin datos disponibles para esta empresa.']];
        }

        return $pendienteFacturar->map(function ($bill) {
            $expirationDate = Carbon::parse($bill->expiration_date);
            $today = Carbon::now();
           // $daysRemaining = $expirationDate ? $expirationDate->diffInDays($today, false) : 'SIN FECHA';

            return [
                'bill_number' => $bill->bill_number,
                //'bill_date' => $bill->bill_date ? $bill->bill_date->format('d-m-Y') : 'SIN FECHA',
                //'expiration_date' => $bill->expiration_date ? $bill->expiration_date->format('d-m-Y') : 'SIN FECHA',
                //'days_remaining' => $daysRemaining,
                'total_payment' => $bill->total_payment,
                'status' => $bill->status,
            ];
        })
        ->toArray();

        return $pendienteFacturar;
    }

    public function headings(): array
    {
        return[
            'Número de Factura', 
           // 'Fecha de Factura',
            //'Fecha de Expiración',
            //'Dias vencidos/ Por Vencer',
            'Total a Pagar',
            'Status',

        ];
    }


public function title(): string
    {
        return $this->empresa->name;
    }

    public function columnFormats(): array
    {
        return [
            //FECHAS
            //'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            //'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            //MONTOS
            'B' => '"$"#,##0.00_-',


        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $empresaId = $this->empresa; // Acceder a la empresa actual
    
                // Ajustar automáticamente el ancho de las columnas en esta hoja
                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }   
            }
        ];
}
}