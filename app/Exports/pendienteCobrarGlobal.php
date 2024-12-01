<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

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
       // Fecha actual
    $hoy = Carbon::now();

    // Obtén todas las facturas pendientes de cobrar
    $facturasPendientes = Bill::where('status', 'pendiente_cobrar')
        ->with('companyreceivable') // Eager loading para evitar múltiples consultas
        ->get()
        ->map(function ($bill) use ($hoy) {
            $expirationDate = $bill->expiration_date ? Carbon::parse($bill->expiration_date) : null;

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
                
                // Calcula los días vencidos o días restantes
                'Dias vencidos' => $expirationDate 
                ? floor($expirationDate->diffInDays($hoy, false)) // Diferencia en días con signo redondeada hacia abajo
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
            'Dias vencidos o Por Vencer',
            'Total',
            'Gran Total Facturas Pendientes'
        ];
    }

    public function title(): string
    {
        return 'Facturas Pendientes de Cobrar';
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

                // Ajustar automáticamente el ancho de las columnas en esta hoja
                foreach (range('A', $event->sheet->getHighestColumn()) as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
                //Filtros
                $event->sheet->setAutoFilter('A1:G1');

                // Aplicar estilos a la fila de encabezado (fila 1)
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFCCCCCC'], // Gris claro
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                //

                // Alternar colores de fondo en las filas para el efecto "striped"
                $highestRow = $event->sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) { // Comienza en la fila 7 para los datos
                    $color = ($row % 2 === 0) ? 'FFE0EAF1' : 'FFFFFFFF'; // Azul claro y blanco
                    $event->sheet->getStyle("A{$row}:G{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => $color],
                        ],
                    ]);
                }

                //Centrar texto
                $event->sheet->getStyle('A:Z')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

            },
        ];
    }
}