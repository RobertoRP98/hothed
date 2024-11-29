<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;

class pendienteCobrarGlobal implements
 FromArray, WithTitle, WithHeadings,
 WithColumnFormatting, ShouldAutoSize, WithEvents
{
    
    protected $totalPendienteCobrarGlobal;

    public function __construct()
    {
        // Calcula el monto total de las facturas pendientes de cobrar
        $this->totalPendienteCobrarGlobal = Bill::where('status', 'pendiente_cobrar')
            ->sum('total_payment');
    }

    public function array(): array
    {
        // Obtén todas las facturas pendientes de cobrar
        $facturasPendientes = Bill::where('status', 'pendiente_cobrar')
            ->with('companyreceivable') // Eager loading para evitar múltiples consultas
            ->get()
            ->map(function ($bill) {
                
                return [
                    
                   'Cliente' => $bill->companyreceivable->name,
            'No. Factura' => $bill->bill_number,
            'Fecha Factura' => $bill->bill_date 
                ? Date::dateTimeToExcel(Carbon::parse($bill->bill_date)) 
                : 'SIN FECHA ASIGNADA',
            'Fecha de entrada' => $bill->entry_date 
                ? Date::dateTimeToExcel(Carbon::parse($bill->entry_date)) 
                : 'SIN FECHA ASIGNADA',
            'Fecha de expiración' => $bill->expiration_date 
                ? Date::dateTimeToExcel(Carbon::parse($bill->expiration_date)) 
                : 'SIN FECHA ASIGNADA',

            'Dias vencidos' => $bill->expiration_date 
                ? floor(Carbon::now()->diffInDays(Carbon::parse($bill->expiration_date), false)) 
                : 'SIN FECHA ASIGNADA',


            'Total' => $bill->total_payment,
            'Gran Total Facturas Pendientes' => '', // Espacio reservado para el total general
                ];
            })
            ->toArray();

        return $facturasPendientes;
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'No. Factura',
            'Fecha Factura',
            'Fecha de entrada',
            'Fecha de expiración',
            'Dias vencidos',
            'Total',
            'Gran Total Facturas Pendientes'
        ];
    }

    public function title(): string
    {
        return 'Facturas Pendientes';
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => '"$"#,##0.00_-', // Formato de moneda para la columna G
            'H' => '"$"#,##0.00_-', // Formato de moneda para la columna H
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Coloca el total en la celda H2
                $event->sheet->setCellValue('H2', $this->totalPendienteCobrarGlobal);
            },
        ];
    }
}