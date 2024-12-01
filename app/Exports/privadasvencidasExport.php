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

class privadasvencidasExport implements
 FromArray, WithHeadings, WithTitle,
  WithColumnFormatting, ShouldAutoSize, WithEvents
{
    protected $totalPrivadasVencidas;

    public function __construct()
    {
        // Monto total de las facturas vencidas pendientes de cobrar 
        $this->totalPrivadasVencidas = Bill::whereHas('companyreceivable', function ($query) {
            $query->where('type', 'Privada');
        })->where('status', 'pendiente_cobrar')
            ->get()
            ->filter(function ($bill) {
                $expirationDate = Carbon::parse($bill->expiration_date);
                $today = Carbon::now();
                return $expirationDate->diffInDays($today, false) >= 0; // SOLO VENCIDAS
            })
            ->sum('total_payment');   
    }



    public function array(): array
    {

        // Fecha actual para cálculo de días vencidos
        $today = Carbon::now();

        // Facturas vencidas
        $facturasprivvenc = Bill::where('status', '=', 'pendiente_cobrar')
            ->whereHas('companyreceivable', function ($query) {
                $query->where('type', 'Privada');
            })
            ->get()
            ->filter(function ($bill) use ($today){
                $expirationDate = Carbon::parse($bill->expiration_date);
                return $expirationDate->diffInDays($today, false) >= 0; // Facturas vencidas o por vencer
            })
            ->map(function ($bill) use ($today){
                $expirationDate = Carbon::parse($bill->expiration_date);
                $bill->diasExpirados = floor($expirationDate->diffInDays($today, false));

                return[
                    'Cliente' => $bill->companyreceivable->name,
                    'No. Factura' => $bill->bill_number,
                    'Fecha Factura' => Date::dateTimeToExcel(Carbon::parse($bill->bill_date)),
                    'Fecha de entrada' => Date::dateTimeToExcel(Carbon::parse($bill->entry_date)),
                    'Fecha de expiracion' => Date::dateTimeToExcel(Carbon::parse($bill->expiration_date)),
                    'Dias vencidos' => $bill->diasExpirados,
                    'Total' => $bill->total_payment,
                    'Gran Total Facturas Vencidas' => '',
                ];
            })
            ->toArray();

        return $facturasprivvenc;
    }

    public function headings(): array{
        return[
            'Cliente',
            'No. Factura',
            'Fecha Factura',
            'Fecha de entrada',
            'Fecha de expiración',
            'Dias vencidos',
            'Total a Cobrar',
            'Gran Total Facturas Vencidas'
        ];
    }

    public function title(): string
    {
        return 'Vencidas Privadas';
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => '"$"#,##0.00_-', // Ajusta la columna 'G' según tu archivo
            'H' => '"$"#,##0.00_-', 
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Coloca el total en la celda H2
                $event->sheet->setCellValue('H2', $this->totalPrivadasVencidas);

                // Ajustar automáticamente el ancho de las columnas en esta hoja
                foreach (range('A', $event->sheet->getHighestColumn()) as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                //Filtros
                $event->sheet->setAutoFilter('A1:G1');

                //

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
