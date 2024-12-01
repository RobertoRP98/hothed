<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Bill;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ResumenSemanaActual implements 
FromCollection, 
WithHeadings, 
WithMapping,
WithTitle,
WithColumnFormatting,
ShouldAutoSize,
WithEvents

{
public function collection()
    {
        // Calcula el lunes de la semana en curso
        $hoy = Carbon::now(); // Fecha actual
        $lunesActual = $hoy->copy()->startOfWeek(); // Lunes de la semana actual

        // Filtra y agrupa los datos de la semana en curso
        $resultados = Bill::select(
            'companyreceivable_id',
            DB::raw("SUM(CASE WHEN status = 'pendiente_cobrar' AND bill_date >= '{$lunesActual}' THEN total_payment ELSE 0 END) AS total_pendiente_cobrar"),
            DB::raw("SUM(CASE WHEN status = 'pagado' AND payment_day >= '{$lunesActual}' THEN total_payment ELSE 0 END) AS total_pagado")
        )
        ->groupBy('companyreceivable_id')
        ->get();

        return $resultados;
    }

    public function headings(): array
    {
        return ['COMPAÑIA', 'FACTURADO USD', 'PAGADO USD'];
    }

    public function map($row): array
    {
        return [
            $row->companyReceivable->name, // Nombre de la empresa usando la relación
            $row->total_pendiente_cobrar,
            $row->total_pagado,
        ];
    }

    public function title(): string
    {
        return 'Resumen Semana Actual';
    }

    public function columnFormats(): array
    {
        return [
            //MONTOS
            'B' => '"$"#,##0.00_-',
            'C' => '"$"#,##0.00_-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
    
                // Ajustar automáticamente el ancho de las columnas en esta hoja
                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
                //FILTROS
                $sheet->setAutoFilter('A1:C1');

                // Aplicar estilos a la fila de encabezado (fila 1)
                $sheet->getStyle('A1:C1')->applyFromArray([
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
                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) { // Comienza en la fila 7 para los datos
                    $color = ($row % 2 === 0) ? 'FFE0EAF1' : 'FFFFFFFF'; // Azul claro y blanco
                    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['argb' => $color],
                        ],
                    ]);
                }

                //Centrar texto
                $sheet->getStyle('A:Z')->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);
    }
];
    }
}