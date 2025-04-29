<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ProveedorConcluidoSinPagoLocalExport implements 
FromCollection,
WithHeadings,
WithTitle,
WithColumnFormatting,
ShouldAutoSize,
WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PurchaseOrder::where('po_status', 'PENDIENTE DE PAGO (SERVICIO CONCLUIDO)')
            ->where('type_op','Local')
            ->with('supplier')
            ->get()
            ->groupBy('supplier_id')
            ->map(function ($orders, $supplierId) {
                $supplier = $orders->first()->supplier;

                return [
                    'Proveedor' => $supplier->name,
                    'RFC' => $supplier->rfc,
                    'Divisa' => $orders->first()->currency,
                    'Total Pagado' => $orders->sum('total'),

                ];
            })

            ->values();
    }

    public function headings(): array
    {
        return [
            'PROVEEDOR',
            'RFC',
            'DIVISA',
            'TOTAL PAGADO'
        ];
    }

    public function title(): string
    {
        return 'SERV/COMP CONCLUIDO PENDIENTE DE PAGO';
    }

    public function columnFormats(): array
    {
        return [
            //MONTOS
            'D' => '"$"#,##0.00_-',

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
                $sheet->setAutoFilter('A1:D1');

                // Aplicar estilos a la fila de encabezado (fila 1)
                $sheet->getStyle('A1:D1')->applyFromArray([
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
                    $sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
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
